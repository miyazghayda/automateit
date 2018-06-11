<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use InstagramAPI\Instagram;
use InstagramAPI\Media\Photo\InstagramPhoto;
use InstagramAPI\Media\Video\InstagramVideo;
use InstagramAPI\Constants;
use InstagramAPI\Signatures;
use InstagramAPI\Exception;
// -------- locking single command mechanism
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
// -------- end locking

class PostingCommand extends Command {
    public $Accounts;
    public $Cargos;
    public $Reaps;
    public $delayed;
    public $photoPath;
    // -------- locking single command mechanism
    public $fileCommandCheck;
    public $commandCheck;
    // -------- end locking

    public function initialize() {
        parent::initialize();
        // Load model yang akan digunakan
        $this->Accounts = $this->loadModel('Accounts');
        $this->Cargos = $this->loadModel('Cargos');
        $this->Reaps = $this->loadModel('Reaps');
        $this->delayed = 60;
        $this->photoPath = WWW_ROOT . 'files' . DS . 'images' . DS . 'upload' . DS;

        // -------- locking single command mechanism
        // Check if this command is already running
        $this->fileCommandCheck = new File(WWW_ROOT . 'commandcheck/checkposting.txt', false, 0644);
        $this->commandCheck = $this->fileCommandCheck->read();
        // If 1, command is already running, don't run the same command
        // Bypass for testing purpose, delete on production
        // $this->commandCheck = 0;
        // Bypassing end here
        if ($this->commandCheck === '1') {
            $this->abort();
        }
        // -------- end locking
    }

    public function execute(Arguments $args, ConsoleIo $io) {
        while (true) {
            $ig = new Instagram(false, false);

            $io->out("Menunggu Akun yang akan mengupload konten pada " . date("d-m-Y H:i:s"));
            // -------- locking single command mechanism
            // Update command check file so no this command will not call by other process
            $this->fileCommandCheck->write(1, 'w', true);
            // -------- end locking

            $query = $this->Cargos->find()
                          ->where(['uploaded' => 0, 'active' => 1, 'schedule <=' => date('Y-m-d H:i')])
                          ->group(['account_id']);

            if ($query->count() > 0) {
                foreach ($query->select(['account_id'])->all() as $q) {
                    $account = $this->Accounts->find()
                                    ->where(['id' => $q['account_id']])
                                    ->first();

                    $cargos = $this->Cargos->find()
                                   ->where([
                                   'Cargos.uploaded' => 0,
                                   'Cargos.active' => 1,
                                   'Cargos.schedule <=' => date('Y-m-d H:i'),
                                   'Cargos.account_id' => $q['account_id']])
                                   ->contain(['Accounts', 'Reaps'])
                                   ->all();

                    $io->out("Login pada akun IG {$account['username']} dengan password {$account['password']}");
                    try {
                        // Login akun IG
                        $ig->login($account['username'], $account['password']);

                        foreach ($cargos as $cargo) {
                            $queryUpdate = $this->Cargos->query();
                            // Upload content
                            if (count($cargo['reaps']) > 1) {// if multiple photo a.k.a album
                                $this->uploadAlbum($ig, $cargo);
                            } elseif (count($cargo['reaps']) == 1) {// if single photo
                                $this->uploadPhoto($ig, $cargo);
                            }
                            sleep($this->delayed);
                        }// .foreach cargos
                    } catch(Exception $e) {
                        $io->out($e);
                    }// .try login ig
                }// .foreach account_id
            }// .if query count > 0

            sleep($this->delayed);

            // -------- locking single command mechanism
            // Update command check so this command can call it self
            $this->fileCommandCheck->write(0, 'w', true);
            // -------- end locking
        }// .while true
    }// .public function execute

    private function uploadPhoto($ig = null, $cargo = []) {
        $io = new ConsoleIo;
        $io->out("Mengupload Foto dengan caption {$cargo['caption']}");
        try{
            $content = new InstagramPhoto($this->photoPath . $cargo['reaps'][0]['id'] . '.' . $cargo['reaps'][0]['extension']);
            $uploading = $ig->timeline->uploadPhoto($content->getFile(), ['caption' => $cargo['caption']]);

            if ($uploading->getStatus() == 'ok') {
                $queryUpdate = $this->Cargos->query();
                $queryUpdate->update()
                             ->set(['uploaded' => 1])
                             ->where(['id' => $cargo['id']])
                             ->execute();
                return true;
            }
            $io->out('Gagal mengupload media');
        } catch(Exception $e) {
            $io->out($e);
            return false;
        }
    }// .private function uploadPhoto

    private function uploadAlbum($ig = null, $cargo = []) {
        $io = new ConsoleIo;
        $io->out("Mengupload Album dengan caption {$cargo['caption']}");
        $media = [];
        foreach($cargo['reaps'] as $reap) {
            array_push($media, ['type' => 'photo', 'file' => $this->photoPath . $reap['id'] . '.' . $reap['extension']]);
        }
        $mediaOptions = ['targetFeed' => Constants::FEED_TIMELINE_ALBUM];

        foreach($media as &$item) {
            $validMedia = null;
            switch ($item['type']) {
            case 'photo':
                $validMedia = new InstagramPhoto($item['file'], $mediaOptions);
                break;
            case 'video':
                $validMedia = new InstagramVideo($item['file'], $mediaOptions);
                break;
            default:

            }
            if ($validMedia === null) {
                continue;
            }

            try {
                $item['file'] = $validMedia->getFile();
                $item['__media'] = $validMedia;
            } catch(Exception $e) {
                continue;
            }
            if (!isset($mediaOptions['forceAspectRatio'])) {
                $mediaDetails = $validMedia instanceof InstagramPhoto
                    ? new \InstagramAPI\Media\Photo\PhotoDetails($item['file'])
                    : new \InstagramAPI\Media\Video\VideoDetails($item['file']);
                $mediaOptions['forceAspectRatio'] = $mediaDetails->getAspectRatio();
            }
        }// .foreach media

        try {
            $uploading = $ig->timeline->uploadAlbum($media, ['caption' => $cargo['caption']]);
            if ($uploading->getStatus() == 'ok') {
                $queryUpdate = $this->Cargos->query();
                $queryUpdate->update()
                             ->set(['uploaded' => 1])
                             ->where(['id' => $cargo['id']])
                             ->execute();
                return true;
            }
        } catch(Exception $e) {
            $io->out($e);
            return false;
        }
    }// .private function uploadAlbum
}
