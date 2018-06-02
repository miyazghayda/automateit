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
}
