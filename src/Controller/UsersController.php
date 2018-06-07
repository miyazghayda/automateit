<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\Time;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController
{

    public function initialize() {
        parent::initialize();
        $this->Auth->allow(['logout', 'add']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        //$users = $this->paginate($this->Users);

        //$this->set(compact('users'));
        $user = $this->Auth->user();
        $this->set('user', $user);
    }

    public function login() {
        $this->viewBuilder()->setLayout('login');
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);

                // Update lastlog
                $userId = $this->Auth->user('id');
                $query = $this->Users->query();
                $query->update()
                      ->set(['lastlog' => Time::now()->i18nFormat('yyyy-MM-dd HH:mm:ss')])
                      ->where(['id' => $this->Auth->user('id')])
                      ->execute();

                return $this->redirect($this->Auth->redirectUrl(['controller' => 'Documentation', 'action' => 'wellcome']));
            }
            $this->Flash->error('Username dan Password Keliru.');
        }
    }

    public function logout() {
        $this->Flash->success('Anda telah logout');
        return $this->redirect($this->Auth->logout());
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => ['Accounts']
        ]);

        $this->set('user', $user);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $this->viewBuilder()->setLayout('register');

        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $time = Time::now();
            $newData = $this->request->getData();
            $newData['groupid'] = 3;
            $newData['statusid'] = 2;
            $newData['lastlog'] = Time::now()->i18nFormat('yyyy-MM-dd HH:mm:ss');
            $newData['active'] = true;
            $user = $this->Users->patchEntity($user, $newData);
            if ($this->Users->save($user)) {
                $this->Flash->success(__('Pendaftaran berhasil, silahkan Login'));

                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('Ups, terjadi kesalahan. Silahkan mencoba lagi.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
