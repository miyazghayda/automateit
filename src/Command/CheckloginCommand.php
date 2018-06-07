<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use InstagramAPI\Instagram;
use InstagramAPI\Signatures;
use InstagramAPI\Exception;
// -------- locking single command mechanism
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
// -------- end locking


class CheckloginCommand extends Command {
    public $Accounts;
    public $delayed;
    // -------- locking single command mechanism
    public $fileCommandCheck;
    public $commandCheck;
    // -------- end locking

    public function initialize() {
        parent::initialize();
        // Load model yang akan digunakan
        $this->Accounts = $this->loadModel('Accounts');

        $this->delayed = 60;

        // -------- locking single command mechanism
        // Check if this command is already running
        $this->fileCommandCheck = new File(WWW_ROOT . 'commandcheck/checklogin.txt', false, 0644);
        $this->commandCheck = $this->fileCommandCheck->read();
        // If 1, command is already running, don't run the same command
        if ($this->commandCheck === '1') {
            $this->abort();
        }
        // -------- end locking
    }

    public function execute(Arguments $args, ConsoleIo $io) {
        while (true) {
            $ig = new Instagram(false, false);

            $io->out("Menunggu Akun yang akan diperiksa loginnya pada " . date("d-m-Y H:i:s"));
            // -------- locking single command mechanism
            // Update command check file so no this command will not call by other process
            $this->fileCommandCheck->write(1, 'w', true);
            // -------- end locking

            $query = $this->Accounts->find()
                          ->where(['statusid' => 1, 'active' => 1]);

            if ($query->count() > 0) {
                //$ig = new Instagram(false, false);

                $accounts = $query->all();
                foreach ($accounts as $account) {
                    $queryUpdate = $this->Accounts->query();
                    // Login akun IG
                    $io->out("Login pada akun IG {$account->username} dengan password {$account->password}");
                    try {
                        $ig->login($account->username, $account->password);

                        // Get Profile Data
                        try {
                            $data = $ig->people->getInfoByName($account->username, 'newsfeed');
                            $queryUpdate->update()
                                        ->set([
                                        'pk' => $data->getUser()->getPk(),
                                        'profpicurl' => $data->getUser()->getHdProfilePicUrlInfo()->getUrl(),
                                        'username' => $account->username,
                                        'fullname' => $data->getUser()->getFullName(),
                                        'password' => $account->password,
                                        'description' => $data->getUser()->getBiography(),
                                        'followers' => $data->getUser()->getFollowerCount(),
                                        'followings' => $data->getUser()->getFollowingCount(),
                                        'posts' => $data->getUser()->getMediaCount(),
                                        'closed' => $data->getUser()->getIsPrivate(),
                                        'statusid' => 3,
                                        'note' => 'Login berhasil, akun dapat digunakan'
                                    ])
                                    ->where(['id' => $account->id])
                                    ->execute();
                            $io->out('Berhasil login');
                            $io->out('Mendownload foto profil');
                            // Get profile picture
                            $this->getProfilePicture($account->username, $account->id);
                        } catch (Exception $e) {
                            $queryUpdate->update()->set(['statusid' => 2, 'note' => 'Login gagal, silahkan perbaiki username dan password'])
                                        ->where(['id' => $account->id])->execute();
                            $io->out($e->getMessage());
                        }// .try get people data
                    } catch(Exception $e) {
                        $queryUpdate->update()->set(['statusid' => 2, 'note' => 'Login gagal, silahkan perbaiki username dan password'])
                                    ->where(['id' => $account->id])->execute();
                        $io->out($e->getMessage);
                    }// .try login
                }// .foreach accounts
            }

            sleep($this->delayed);

            // -------- locking single command mechanism
            // Update command check so this command can call it self
            $this->fileCommandCheck->write(0, 'w', true);
            // -------- end locking
        }// .while
    }// .public function execute

    private function getProfilePicture($username, $id) {
        // Based on https://github.com/sounden/phinstagram/blob/master/phinstagram.php
        $phpinstagram_json_object = null;

        define('TMP_DIR', TMP);
        define('CACHE_FILE_NAME', $username . '.json');
        define('LOCAL_CACHE_IN_SECONDS', 300);

        if(file_exists(TMP_DIR . DS . CACHE_FILE_NAME) && (filemtime(TMP_DIR . DS . CACHE_FILE_NAME) > (time() - LOCAL_CACHE_IN_SECONDS))) {
            // fetch from disk //
            $phinstagram_json_object = json_decode(file_get_contents(TMP_DIR . DS . CACHE_FILE_NAME));
        } else {
            // get a fresh download
            $ch = curl_init();
            // set the url to appropriate user
            curl_setopt($ch, CURLOPT_URL, "https://www.instagram.com/$username/");
            // return data
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // set a custom useragent
            curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36');
            $html = curl_exec($ch);
            curl_close($ch);

            // Create a new DOMDocument to parse the result in
            $doc = new \DOMDocument();

            //supress the HTML5 tags warning //
            libxml_use_internal_errors(true);

            // Load content as DOMDocument //
            $doc->loadHTML($html);

            // Check every line in the textContent node //
            foreach(explode("\n", $doc->textContent) as $line) {
                // When string found, fix it and make a json object from it
                if (strpos($line, 'window._sharedData = ') !== false) {
                    // do some cleanup before we can use it as json
                    $json_string = str_replace("window._sharedData = ",'',$line);
                    //$json_string = substr($json_string, 0, -1);
                    $json_string = str_replace(';', ',',$json_string);
                    // replace last string
                    $json_string = substr_replace($json_string ,"",-1,1);
                    // decode the string to an object //
                    $phinstagram_json_object = json_decode($json_string);
                }
            }

            if($phinstagram_json_object == NULL)
            {
                // return last working json string if it exists //
                if (file_exists(TMP_DIR . DS . CACHE_FILE_NAME)) {
                    $phinstagram_json_object = json_decode(file_get_contents(TMP_DIR . DS . CACHE_FILE_NAME));
                } else {
                    //oh nooo .. we didnt have a stored old json string on disk.. nor parsing instagram.com site succeeded!!! FAIL, DIE()!
                    $phinstagram_json_object = array("error" => json_last_error());
                }
            } else {
                // save to local cache if the new one works //
                file_put_contents(TMP_DIR . DS . CACHE_FILE_NAME, $json_string);
            }
        }

        //if(isset($phpinstagram_json_object->entry_data)) {
            $json = json_encode($phinstagram_json_object->entry_data->ProfilePage[0]->graphql->user->profile_pic_url);
            $url = str_replace('\/', '/', $json);
            $url = str_replace('"', '', $url);

            $queryUpdate = $this->Accounts->query();

            $queryUpdate->update()
                        ->set([
                        'profpicurl' => $url
                    ])
                    ->where(['id' => $id])
                    ->execute();

            // Download photo
            $fp = fopen(WWW_ROOT . 'files' . DS . 'images' . DS . 'profilepicture' . DS . $id . '.jpg', 'w+');
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1000);
            curl_setopt($ch, CURLOPT_USERAGENT, 'any');
            curl_exec($ch);
            curl_close($ch);
            fclose($fp);

            /*set_time_limit(0);
            $options = [
                CURLOPT_FILE => WWW_ROOT . 'files' . DS . 'images' . DS . 'profilepicture' . DS . $id . '.jpg',
                CURLOPT_TIMEOUT => 28800,
                CURLOPT_URL => $url
            ];
            $ch = curl_init();
            curl_setopt_array($ch, $options);
            curl_exec($ch);
            curl_close($ch);*/
        //}
    }
}
