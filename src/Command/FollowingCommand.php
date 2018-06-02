<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
use InstagramAPI\Instagram;
use InstagramAPI\Signatures;
use InstagramAPI\Exception;

class FollowingCommand extends Command {
    public $Accounts;
    public $Members;
    public $Idols;
    public $Vassals;

    public function initialize() {
        parent::initialize();
        // Load model yang akan digunakan
        $this->Accounts = $this->loadModel('Accounts');
        $this->Members = $this->loadModel('Members');
        $this->Idols = $this->loadModel('Idols');
        $this->Vassals = $this->loadModel('Vassals');
    }

    public function buildOptionParser(ConsoleOptionParser $parser) {
        // Argumen/variabel yang harus diisi saat pemanggilan command
        // main_account adalah username, tanpa tanda @, utama, mis. miyazghayda
        // counter adalah banyaknya following, mis. 50, 100, 150
        $parser->addArguments([
            'main_account' => ['help' => 'Username akun utama, tanpa @, contohnya miyazghayda', 'required' => true],
            'counter' => ['help' => 'Banyaknya following(s), maksimum 1000, contohnya 50, 100, 150', 'required' => true]
        ]);
        return $parser;
    }

    public function execute(Arguments $args, ConsoleIo $io) {
        $main_account = $args->getArguments()[0];
        $counter = $args->getArguments()[1];
        $counter > 1000 ? $counter = 1000 : $counter = $counter;
        $ig = new Instagram(false, false);

        // Uji apakah username terdaftar
        $main_account_check = $this->checkAccount($main_account, 1);
        if ($main_account_check[0] == false) {
            $io->out($main_account_check[1]);
            return false;
        }
        $main_account = $main_account_check[1];

        // Login akun IG
        $io->out("Login pada akun IG {$main_account['username']} dengan password {$main_account['password']}");
        try {
            $ig->login($main_account['username'], $main_account['password']);
        } catch(Exception $e) {
            $message = $e->getMessage();
        }

        // Ambil semua data idola
        $query_idol = $this->Idols->find()
                           ->where([
                           'Idols.account_id' => $main_account_check[1]['id'],
                           'Idols.active' => 1
                       ]);
        if ($query_idol->count() < 1) {
            $io->out('Tidak terdapat akun idola');
            return false;
        }
        $following_per_idol = floor($counter / $query_idol->count());
        $query_idol->contain(['Accounts', 'Members']);
        $idols = $query_idol->all();
        $following_per_idol = floor($counter / $query_idol->count());
        $i = 1;

        foreach ($idols as $idol) {
            $io->out("Memfollow follower(s) akun {$idol->member->username}");
            // Ambil semua data follower(s) akun idola yang belum difollow
            $query_vassal = $this->Vassals->find()
                                 ->where([
                                 'Vassals.idol_id' => $idol->id,
                                 'Vassals.followed' => 0,
                                 'Vassals.active' => 1
                             ]);
            if ($query_vassal->count() > 0) {
                $following_per_idol >= $query_vassal->count() ? $counter = $query_vassal->count() : $counter = $following_per_idol;
                $query_vassal->contain(['Accounts']);
                $query_vassal->limit($counter);
                $vassals = $query_vassal->all();

                foreach ($vassals as $vassal) {
                    try {
                        // Follow
                        $following = $ig->people->follow($vassal->account->pk);
                        // Jika berhasil memfollow, update field followed pada tabel vassals
                        if ($following->getStatus() == 'ok') {
                            $io->out("{$i}. Berhasil memfollow {$vassal->account->username}");
                            $i++;
                            $query_update = $this->Vassals->query();
                            $query_update->update()
                                         ->set(['followed' => 1])
                                         ->where(['id' => $vassal->id])
                                         ->execute();
                        }
                    } catch(Exception $e) {
                        $io->out($e->getMessage());
                    }
                    // Jeda 1-5 detik
                    sleep(rand(1, 5));
                }
            }
        }
    }

    private function checkAccount($username = 'miyazghayda', $principal = 0) {
        $ret = false;
        $message = 'Akun tidak terdaftar';

        $query_user = $this->Accounts->find()
                           ->where([
                           'username' => $username,
                           'principal' => $principal,
                           'active' => 1]
                       );
        $count_user = $query_user->count();
        if ($count_user == 1) {
            $user = $query_user->first();
            $ret = true;
            // variabel message diisi dengan info akun utama
            $message = [
                'id' => $user->id,
                'username' => $user->username,
                'password' => $user->password,
                'pk' => $user->pk
            ];
        }
        return [$ret, $message];
    }

}
