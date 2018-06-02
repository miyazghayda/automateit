<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
// -------- locking single command mechanism
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
// -------- end locking

class TestCommand extends Command {
    // -------- locking single command mechanism
    public $fileCommandCheck;
    public $commandCheck;
    // -------- end locking

    public function initialize() {
        parent::initialize();

        // -------- locking single command mechanism
        // Check if this command is already running
        $this->fileCommandCheck = new File(WWW_ROOT . 'commandcheck/test.txt', false, 0644);
        $this->commandCheck = $this->fileCommandCheck->read();
        // If 1, command is already running, don't run the same command
        if ($this->commandCheck === '1') {
            $this->abort();
        }
        // -------- end locking
    }

    /*public function buildOptionParser(ConsoleOptionParser $parser) {
        // Argumen/variabel yang harus diisi saat pemanggilan command
        // main_account adalah username, tanpa tanda @, utama, mis. miyazghayda
        // counter adalah banyaknya following, mis. 50, 100, 150
        $parser->addArguments([
            'username' => ['help' => 'Username akun, tanpa @, contohnya miyazghayda', 'required' => true],
            'password' => ['help' => 'Password akun', 'required' => true]
        ]);
        return $parser;
    }*/

    public function execute(Arguments $args, ConsoleIo $io) {
        while (true) {

            // -------- locking single command mechanism
            // Update command check file so no this command will not call by other process
            $this->fileCommandCheck->write(1, 'w', true);
            // -------- end locking

            $io->out("ini dipanggil");
            sleep(10);

            // -------- locking single command mechanism
            // Update command check so this command can call it self
            $this->fileCommandCheck->write(0, 'w', true);
            // -------- end locking
        }
    }
}
