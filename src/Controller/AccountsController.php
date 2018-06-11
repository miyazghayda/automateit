<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

/**
 * Accounts Controller
 *
 * @property \App\Model\Table\AccountsTable $Accounts
 *
 * @method \App\Model\Entity\Account[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AccountsController extends AppController
{
    public $user;

    public function initialize() {
        parent::initialize();
        $this->user = $this->Auth->user();
    }

    public function isAuthorized($user) {
        $action = $this->request->getParam('action');

        // All actions require an id
        $id = $this->request->getParam('pass.0');
        if (!$id) {
            return false;
        }

        // Check that the account belongs to the current user.
        $account = $this->Accounts->findById($id)->first();

        return $account->user_id === $user['id'];
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $user = $this->Auth->user();

        $accounts = $this->Accounts->find()
                         ->where(['user_id' => $user['id'], 'active' => 1])
                         ->all();

        $user = $this->Auth->user();

        $this->set(compact('accounts', 'user'));
    }

    /**
     * View method
     *
     * @param string|null $id Account id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        if (!$this->isAuthorized($this->user)) {
            $this->redirect('index');
        }

        $account = $this->Accounts->get($id, [
            'contain' => ['Preferences']
        ]);

        $hashtaglists = $this->Accounts->Hashtaglists->find()
                             ->where(['account_id' => $account['id'], 'active' => true, 'typeid' => 1, 'whitelist' => true])
                             ->all()
                             ->toArray();

        // Check if profile picture is exists
        $profilepicture = new File(WWW_ROOT . 'files' . DS . 'images' . DS . 'profilepicture' . DS . $id . '.jpg', false, 0644);
        $pp = false;
        if ($profilepicture->exists()) $pp = true;
        $profilepicture->close();

        $this->set('user', $this->user);
        $this->set(compact('account', 'pp', 'hashtaglists'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $account = $this->Accounts->newEntity();
        if ($this->request->is('post')) {
            $data = [
                'user_id' => $this->Auth->user('id'),
                'proxy_id' => 1,
                'pk' => 0,
                'profpicurl' => null,
                'username' => $this->request->getData()['username'],
                'password' => $this->request->getData()['password'],
                'fullname' => null,
                'description' => null,
                'followers' => 0,
                'followings' => 0,
                'contents' => 0,
                'followtoday' => 0,
                'liketoday' => 0,
                'posttoday' => 0,
                'commenttoday' => 0,
                'started' => Time::now()->i18nFormat('yyyy-MM-dd'),
                'ended' => Time::now()->i18nFormat('yyyy-MM-dd'),
                'paid' => 0,
                'closed' => 0,
                'statusid' => 1,
                'note' => 'Belum diuji login',
                'profpicurlfixed' => false,
                'active' => true
            ];
            $account = $this->Accounts->patchEntity($account, $data);
            if ($this->Accounts->save($account)) {
                // Add Table preferences row related to this account
                $preference = $this->Accounts->Preferences->newEntity();

                $dataPreference = [
                    'account_id' => $account->id,
                    'maxlikeperday' => 500,
                    'maxcommentperday' => 500,
                    'maxfollowperday' => 300,
                    'maxpostperday' => 1,
                    'followidolfollower' => 0,
                    'followbylocation' => 0,
                    'followbyhashtag' => 0,
                    'likefeed' => 0,
                    'likebylocation' => 0,
                    'likebyhashtag' => 0,
                    'commentfeed' => 0,
                    'commentbyhashtag' => 0,
                    'commentbylocation' => 0,
                    'followtoday' => 0,
                    'liketoday' => 0,
                    'commenttoday' => 0,
                    'posttoday' => 0,
                    'hashtagtofollowtoday' => 0,
                    'gethashtagtofollowtoday' => true,
                    'active' => true
                ];
                $preference = $this->Accounts->Preferences->patchEntity($preference, $dataPreference);
                if ($this->Accounts->Preferences->save($preference)) {
                    $this->Flash->success(__('Akun berhasil ditambahkan, sistem akan menguji apakah username dan password dapat digunakan.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('Ups, terjadi kesalahan. Silahkan mengulangi.'));
        }

        $user = $this->Auth->user();
        $this->set(compact('account', 'user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Account id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if (!$this->isAuthorized($this->user)) {
            $this->redirect('index');
        }

        $account = $this->Accounts->get($id, [
            'contain' => ['Preferences']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // Update preferences table
            $preference = $this->Accounts->Preferences->query();
            $preference->update()
                       ->set([
                       'maxlikeperday' => $data['maxlikeperday'],
                       'maxfollowperday' => $data['maxfollowperday'],
                       'followbyhashtag' => $data['followbyhashtag']
                   ])
                   ->where(['account_id' => $account['id'], 'active' => true])
                   ->execute();

            // If account choose to followbyhashtag
            if ($data['followbyhashtag'] && !empty($data['hashtagtofollow'])) {
                $hashtags = explode(',', $data['hashtagtofollow']);
                foreach ($hashtags as $h) {
                    $h = strtolower(trim(str_replace('#', '',$h)));

                    $findHashtag = $this->Accounts->Hashtaglists->find()
                                        ->where(['account_id' => $account['id'], 'active' => true, 'caption' => $h]);
                    if ($findHashtag->count() == 0) {
                        $d = [
                            'account_id' => $account['id'],
                            'typeid' => 1,
                            'whitelist' => true,
                            'caption' => $h,
                            'active' => true
                        ];
                        $hashtaglist = $this->Accounts->Hashtaglists->newEntity();
                        $hashtaglist = $this->Accounts->Hashtaglists->patchEntity($hashtaglist, $d);
                        $this->Accounts->Hashtaglists->save($hashtaglist);
                    }
                }
            }

            $message = 'Setup Akun berhasil diubah.';
            // Update accounts table
            if ($account['password'] != $data['password']) {
                $data['statusid'] = 1;
                $data['note'] = 'Belum diuji login';

                $account = $this->Accounts->patchEntity($account, $data);
                if (!$this->Accounts->save($account)) {
                    $message = 'Ups! Gagal mengubah Setup Akun, silahkan ulangi.';
                }
            }

            $this->Flash->success(__($message));

            return $this->redirect(['action' => 'view', $id]);
        }
        $hashtagWhite = $this->Accounts->Hashtaglists->find()
            ->where(['account_id' => $account['id'], 'active' => 1, 'typeid' => 1, 'whitelist' => 1])->all();

        $hashtagWhiteString = '';
        foreach ($hashtagWhite as $h) $hashtagWhiteString = $hashtagWhiteString . $h['caption'];

        $this->set('user', $this->user);
        $this->set(compact('account', 'hashtagWhiteString', 'hashtagWhite'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Account id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        if (!$this->isAuthorized($this->user)) {
            $this->redirect('index');
        }

        $account = $this->Accounts->get($id, [
            'contain' => ['Preferences']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = ['active' => false];
            $account = $this->Accounts->patchEntity($account, $data);
            if ($this->Accounts->save($account)) {
                $this->Flash->success(__('Berhasil menghapus akun.'));
            } else {
                $this->Flash->success(__('Ups! Gagal menghapus akun, silahkan mengulangi.'));
            }
            return $this->redirect(['action' => 'index']);
        }

        $this->set('user', $this->user);
        $this->set(compact('account'));
    }
}
