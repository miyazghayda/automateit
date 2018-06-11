<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Followinglists Controller
 *
 * @property \App\Model\Table\FollowinglistsTable $Followinglists
 *
 * @method \App\Model\Entity\Followinglist[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FollowinglistsController extends AppController
{
    public $user;
    public $paidAccounts;
    public $orAccounts;
    public $paidAccountIds;

    public function initialize() {
        parent::initialize();
        $this->user = $this->Auth->user();
        $this->paidAccounts = $this->Followinglists->Accounts->find()
             ->where(['user_id' => $this->user['id'], 'active' => 1, 'statusid' => 5])
             ->all();

        // Only show paid (5) account(s)
        $orAccounts = [];
        $paidAccountIds = [];

        foreach ($this->paidAccounts as $account) {
            array_push($orAccounts, ['account_id' => $account['id']]);
            //$orAccounts = array_merge($orAccounts, ['account_id' => $account['id']]);
            array_push($paidAccountIds, $account['id']);
        }
        $this->orAccounts = $orAccounts;
        $this->paidAccountIds = $paidAccountIds;
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

        $accounts = $this->Followinglists->find()
                         ->where(['Followinglists.active' => 1,'Followinglists.followed' => true, 'Followinglists.unfollowed' => false, 'OR' => $this->orAccounts])
                         ->contain(['Members'])
                         ->all();

        $user = $this->Auth->user();

        $this->set(compact('accounts', 'user'));
    }

    /**
     * View method
     *
     * @param string|null $id Followinglist id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $followinglist = $this->Followinglists->get($id, [
            'contain' => ['Vassals', 'Members', 'Fellows', 'Accounts']
        ]);

        $this->set('followinglist', $followinglist);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $followinglist = $this->Followinglists->newEntity();
        if ($this->request->is('post')) {
            $followinglist = $this->Followinglists->patchEntity($followinglist, $this->request->getData());
            if ($this->Followinglists->save($followinglist)) {
                $this->Flash->success(__('The followinglist has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The followinglist could not be saved. Please, try again.'));
        }
        $vassals = $this->Followinglists->Vassals->find('list', ['limit' => 200]);
        $members = $this->Followinglists->Members->find('list', ['limit' => 200]);
        $fellows = $this->Followinglists->Fellows->find('list', ['limit' => 200]);
        $accounts = $this->Followinglists->Accounts->find('list', ['limit' => 200]);
        $this->set(compact('followinglist', 'vassals', 'members', 'fellows', 'accounts'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Followinglist id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $followinglist = $this->Followinglists->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $followinglist = $this->Followinglists->patchEntity($followinglist, $this->request->getData());
            if ($this->Followinglists->save($followinglist)) {
                $this->Flash->success(__('The followinglist has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The followinglist could not be saved. Please, try again.'));
        }
        $vassals = $this->Followinglists->Vassals->find('list', ['limit' => 200]);
        $members = $this->Followinglists->Members->find('list', ['limit' => 200]);
        $fellows = $this->Followinglists->Fellows->find('list', ['limit' => 200]);
        $accounts = $this->Followinglists->Accounts->find('list', ['limit' => 200]);
        $this->set(compact('followinglist', 'vassals', 'members', 'fellows', 'accounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Followinglist id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $followinglist = $this->Followinglists->get($id);
        if ($this->Followinglists->delete($followinglist)) {
            $this->Flash->success(__('The followinglist has been deleted.'));
        } else {
            $this->Flash->error(__('The followinglist could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
