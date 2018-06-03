<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

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

        $this->set('user', $this->user);
        $this->set('account', $account);
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
                'posts' => 0,
                'started' => Time::now()->i18nFormat('yyyy-MM-dd'),
                'ended' => Time::now()->i18nFormat('yyyy-MM-dd'),
                'paid' => 0,
                'closed' => 0,
                'statusid' => 1,
                'note' => 'Belum diuji login',
                'active' => 1
            ];
            $account = $this->Accounts->patchEntity($account, $data);
            if ($this->Accounts->save($account)) {
                // Add Table preferences row related to this account
                $preference = $this->Accounts->Preferences->newEntity();

                $dataPreference = [
                    'account_id' => $account->id,
                    'maxlikeperday' => 1000,
                    'maxfollowperday' => 1000,
                    'maxpostperday' => 1,
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

    private function loginIg($username = '', $password = '') {
        $ret = false;
        $message = 'Gagal Login pada Akun IG' . $username;
        if (!empty($username) && !empty($password)) {
            Instagram::$allowDangerousWebUsageAtMyOwnRisk = true;
            $ig = new Instagram(false, false);

            // Login
            try {
                $ig->login($username, $password);
            } catch (Exception $e) {
                $message = $message . ' ' . $e->getMessage();
                return [$ret, $message];
            }

            // Get Profile Data
            try {
                $data = $ig->people->getInfoByName($username, 'newsfeed');
                $ret = true;
                $message = [
                    'pk' => $data->getUser()->getPk(),
                    'sourceid' => $data->getUser()->getPk(),
                    'username' => $username,
                    'fullname' => $data->getUser()->getFullName(),
                    'password' => $password,
                    'description' => $data->getUser()->getBiography(),
                    'followers' => $data->getUser()->getFollowerCount(),
                    'followings' => $data->getUser()->getFollowingCount(),
                    'posts' => $data->getUser()->getMediaCount(),
                    'closed' => $data->getUser()->getIsPrivate()
                ];
            } catch (Exception $e) {
                $message = $message . ' ' . $e->getMessage();
            }
        }
        return [$ret, $message];
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
        $account = $this->Accounts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $account = $this->Accounts->patchEntity($account, $this->request->getData());
            if ($this->Accounts->save($account)) {
                $this->Flash->success(__('The account has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The account could not be saved. Please, try again.'));
        }
        $users = $this->Accounts->Users->find('list', ['limit' => 200]);
        $proxies = $this->Accounts->Proxies->find('list', ['limit' => 200]);
        $this->set(compact('account', 'users', 'proxies'));
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
        $this->request->allowMethod(['post', 'delete']);
        $account = $this->Accounts->get($id);
        if ($this->Accounts->delete($account)) {
            $this->Flash->success(__('The account has been deleted.'));
        } else {
            $this->Flash->error(__('The account could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
