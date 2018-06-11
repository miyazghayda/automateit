<?php
namespace App\Command;

use Cake\Console\Arguments;
use Cake\Console\Command;
use Cake\Console\ConsoleIo;
use Cake\Console\ConsoleOptionParser;
use InstagramAPI\Instagram;
use InstagramAPI\Constants;
use InstagramAPI\Signatures;
use InstagramAPI\Exception;
// -------- locking single command mechanism
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;
// -------- end locking

class FollowhashtagCommand extends Command {
    public $Accounts;
    public $Hashtaglists;
    public $Followinglists;
    public $Members;
    public $Locations;
    public $Posts;
    public $Wads;
    public $delayed;
    public $followDelay;
    public $photoPath;
    // -------- locking single command mechanism
    public $fileCommandCheck;
    public $commandCheck;
    // -------- end locking

    public function initialize() {
        parent::initialize();
        // Load model yang akan digunakan
        $this->Accounts = $this->loadModel('Accounts');
        $this->Hashtaglists = $this->loadModel('Hashtaglists');
        $this->Followinglists = $this->loadModel('Followinglists');
        $this->Members = $this->loadModel('Members');
        $this->Locations = $this->loadModel('Locations');
        $this->Posts = $this->loadModel('Posts');
        $this->Wads = $this->loadModel('Wads');

        $this->delayed = 60;
        $this->followDelay = 38;

        // -------- locking single command mechanism
        // Check if this command is already running
        $this->fileCommandCheck = new File(WWW_ROOT . 'commandcheck/checkfollowhashtag.txt', false, 0644);
        $this->commandCheck = $this->fileCommandCheck->read();
        // If 1, command is already running, don't run the same command
        // Bypass for testing purpose, delete on production
        $this->commandCheck = 0;
        // Bypassing end here
        if ($this->commandCheck === '1') {
            $this->abort();
        }
        // -------- end locking
    }

    public function execute(Arguments $args, ConsoleIo $io) {
        while (true) {
            $ig = new Instagram(false, false);

            $io->out("Menunggu Akun yang akan memfollow user berdasarkan hashtags pada " . date("d-m-Y H:i:s"));
            // -------- locking single command mechanism
            // Update command check file so no this command will not call by other process
            $this->fileCommandCheck->write(1, 'w', true);
            // -------- end locking

            $query = $this->Accounts->find()
                          ->where(['Accounts.statusid' => 5, 'Accounts.active' => true])
                          ->contain(['Hashtaglists', 'Preferences']);

            $query->matching('Preferences', function($q) {
                return $q->where(['Preferences.followbyhashtag' => true]);
            });

            if ($query->count() > 0) {
                $accounts = $query->all();
                foreach ($accounts as $account) {
                    $totalFollowPerHashtag = floor($account['preferences'][0]['maxfollowperday'] / count($account['hashtaglists']));
                    $io->out("Login pada akun IG {$account['username']}");
                    try {
                        // Login akun IG
                        $ig->login($account['username'], $account['password']);

                        // Get hashtag
                        foreach ($account['hashtaglists'] as $hashtag) {
                            $io->out("Dapatkan konten dengan hashtag {$hashtag['caption']}");
                            $this->getHashtagFeed($ig, $hashtag['caption'], 20);
                            // Call
                        }// .foreach hashtag
                    } catch(Exception $e) {
                        $io->out($e);
                    }// .try login ig
                }// .foreach accounts
            }// .if query count > 0

            sleep($this->delayed);

            // -------- locking single command mechanism
            // Update command check so this command can call it self
            $this->fileCommandCheck->write(0, 'w', true);
            // -------- end locking
        }// .while true
    }// .public function execute

    private function getHashtagFeed($ig = null, $tag = 'exploreindonesia', $maxPostToGet = 20) {
        $io = new ConsoleIo();
        $rankToken = Signatures::generateUUID();
        $maxId = null;
        $postCounter = 0;
        do {
            $io->out($tag);
            $response = $ig->hashtag->getFeed($tag, $rankToken, $maxId);

            foreach ($response->getItems() as $item) {
                $location_id = 1;
                $member_id = $this->insertMember($item->getUser());
                if ($item->hasLocation() && $item->getLocation() !== null) {
                    $location_id = $this->insertLocation($item->getLocation());
                }
                $post_id = $this->insertPost($item, $location_id, $member_id);

            }
            $maxId = $response->getNextMaxId();
            $postCounter = $postCounter + $response->getNumResults();
            $io->out($postCounter);
            $io->out($maxPostToGet);

            // Sleep for 5 secs
            sleep(5);
        } while ($postCounter < $maxPostToGet && $maxId !== null);
    }// .private function getHashtagFeed

    private function insertPost($post = null, $locationId = 1, $memberId = 1) {
        $io = new ConsoleIo;
        $check = $this->Posts->find()
                      ->where(['pk' => $post->getPk(), 'active' => true]);

        if ($check->count() == 1) {
            $ret = $check->first();
            return $ret->id;
        } else {// save post to db
            $data = [
                'comments' => $post->getCommentCount(),
                'likes' => $post->getLikeCount(),
                'caption' => '',
                'takenat' => $post->getTakenAt(),
                'pk' => $post->getPk(),
                'typeid' => $post->getMediaType(),
                'sourceid' => $post->getId(),
                'location_id' => $locationId,
                'member_id' => $memberId,
                'active' => true
            ];
            if ($post->hasCaption() && $post->getCaption() !== null) {
                $data['caption'] = $post->getCaption()->getText();
            }
            // save to db
            $post_id = 0;
            $content = $this->Posts->newEntity();
            $content = $this->Posts->patchEntity($content, $data);
            if ($this->Posts->save($content)) $post_id = $content->id;

            // process each media to insert to db
            if ($post_id > 0 && $post->getMediaType() == 1) {
                $io->out('Menyimpan konten foto');
                $this->insertWad($post->getImageVersions2()->getCandidates()[0], $post_id, $post->getMediaType());
            } elseif ($post_id > 0 && $post->getMediaType() == 2) {
                $io->out('Menyimpan konten video');
                $this->insertWad($post->getVideoVersions()[0], $post_id, $post->getMediaType());
            } elseif ($post_id > 0 && $post->getMediaType() == 8) {
                $io->out('Menyimpan konten carousel');
                $this->insertWad($post->getCarouselMedia(), $post_id, $post->getMediaType());
            }
        }
    }// .private function insertPost

    private function insertWad($media = [], $postId = 1, $typeId = 1) {
        $data = [
            'post_id' => $postId,
            'typeid' => $typeId,
            'sequence' => 0,
            'active' => true
        ];

        if ($typeId == 1 || $typeId == 2) {// single image or video
            $data['url'] = $media->getUrl();
            $data['width'] = $media->getWidth();
            $data['height'] = $media->getHeight();

            // save to db
            $wad = $this->Wads->newEntity();
            $wad = $this->Wads->patchEntity($wad, $data);
            if ($this->Wads->save($wad)) return $wad->id;
        } elseif ($typeId == 8) {// carousel
            $sequence = 0;
            foreach ($media as $m) {
                // assign default value
                $data['url'] = '';
                $data['width'] = 0;
                $data['height'] = 0;
                $data['typeid'] = $m->getMediaType();
                if ($m->getMediaType() == 1) {// image
                    $reap = $m->getImageVersions2()->getCandidates()[0];
                } elseif ($m->getMediaType() == 2) {// video
                    $reap= $m->getVideoVersions()[0];
                }
                $data['url'] = $reap->getUrl();
                $data['width'] = $reap->getWidth();
                $data['height'] = $reap->getHeight();
                $data['sequence'] = $sequence;
                $sequence++;

                // save to db
                $wad = $this->Wads->newEntity();
                $wad = $this->Wads->patchEntity($wad, $data);
                $this->Wads->save($wad);
            }
        }
    }// .private function insertWad

    private function insertLocation($location = null) {
        $check = $this->Locations->find()
                      ->where(['pk' => $location->getPk(), 'active' => true]);

        if ($check->count() == 1) {
            $ret = $check->first();
            return $ret->id;
        } else {// save location to db
            $data = [];
            $data['pk'] = $location->getPk();
            $data['lat'] = $location->getLat();
            $data['lng'] = $location->getLng();
            $data['shortname'] = $location->getShortName();
            $data['name'] = $location->getName();
            $data['address'] = $location->getAddress();
            $data['active'] = true;
            $data['fbplacesid'] = 0;
            if ($location->hasFacebookPlacesId()) {
                $data['fbplacesid'] = $location->getFacebookPlacesId();
            }

            $location = $this->Locations->newEntity();
            $location = $this->Locations->patchEntity($location, $data);
            if ($this->Locations->save($location)) return $location->id;
        }
    }// .private function insertLocation

    private function insertMember($member = null) {
        $check = $this->Members->find()
                      ->where(['pk' => $member->getPk(), 'active' => true]);

        if ($check->count() == 1) {
            $ret = $check->first();
            return $ret->id;
        } else {// save member to db
            $fellow = $this->Members->newEntity();
            $profpicurl = '';
            if ($member->hasProfilePicUrl()) {
                $profpicurl = $member->getProfilePicUrl();
                $profpicurl = explode('.jpg', $profpicurl);
                $profpicurl = $profpicurl[0] . '.jpg';
            }
            $data = [
                'pk' => $member->getPk(),
                'username' => $member->getUsername(),
                'fullname' => $member->getFullName(),
                'description' => $member->getBiography(),
                'profpicurl' => $profpicurl,
                'followers' => 0,
                'followings' => 0,
                'contents' => 0,
                'closed' => false,
                'active' => true
            ];
            $fellow = $this->Members->patchEntity($fellow, $data);
            if ($this->Members->save($fellow)) {
                return $fellow->id;
            }
        }
    }// .private function insertUser
}
