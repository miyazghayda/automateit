<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;

/**
 * Cargos Controller
 *
 * @property \App\Model\Table\CargosTable $Cargos
 *
 * @method \App\Model\Entity\Cargo[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CargosController extends AppController
{
    public $user;
    public $paidAccounts;
    public $orAccounts;
    public $paidAccountIds;

    public function initialize() {
        parent::initialize();
        $this->user = $this->Auth->user();
        $this->paidAccounts = $this->Cargos->Accounts->find()
             ->where(['user_id' => $this->user['id'], 'active' => 1, 'statusid' => 5])
             ->all();

        // Only show paid (5) account(s)
        $orAccounts = [];
        $paidAccountIds = [];

        foreach ($this->paidAccounts as $account) {
            $orAccounts = array_merge($orAccounts, ['account_id' => $account['id']]);
            array_push($paidAccountIds, $account['id']);
        }
        $this->orAccounts = $orAccounts;
        $this->paidAccountIds = $paidAccountIds;

        $this->loadComponent('CakephpJqueryFileUpload.JqueryFileUpload');
        $this->loadComponent('RequestHandler');
    }

    public function queue($id = null) {
        $this->set('user', $this->user);

        $orAccounts = $this->orAccounts;

        if ($id > 0 && in_array($id, $this->paidAccountIdss)) $orAccounts = ['account_id' => $id];

        $cargos = $this->Cargos->find()
                       ->where(['OR' => $orAccounts, 'uploaded' => false, 'active' => 1])
                       ->all();

        $this->set(compact('cargos'));
    }

    public function upload() {
        $this->autoRender = false;
        $this->response->type('json');

        $options = [
            'max_file_size' => 20000000,
            'access_control_allow_methods' => ['POST'],
            'access_control_allow_origin' => Router::fullBaseUrl(),
            'accept_file_types' => '/\.(jpe?g|png)$/i',
            'upload_dir' => WWW_ROOT . 'files' . DS . 'images' . DS . 'upload' . DS,
            'upload_url' => '/files/images/upload/',
            'print_response' => false
        ];

        $result = $this->JqueryFileUpload->upload($options);
        $this->response->body(json_encode($result));
        return $this->response;
        //$this->set(compact('result'));
        //$this->set('_serialize', ['result']);
        //print_r($result);
        // $result['files'][0]['error'] = Filetype not allowed
        // $
        // result['files'][0] = [
        // ->name = 'name.pdf',
        // ->size = 48247
        // ->type = 'application/pdf'
        // ->error => 'Filetype not allowed'
        // ]
        // ->type = 'image/jpeg'
        // ->url = '/files/images/upload/x.jpg' this is url encoded
        // ->thumbnailUrl = '/files/images/upload/thumbnail/x.jpg'
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Accounts']
        ];
        $cargos = $this->paginate($this->Cargos);

        $this->set(compact('cargos'));
    }

    /**
     * View method
     *
     * @param string|null $id Cargo id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $cargo = $this->Cargos->get($id, [
            'contain' => ['Accounts', 'Reaps']
        ]);

        $this->set('cargo', $cargo);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $cargo = $this->Cargos->newEntity();
        if ($this->request->is('post')) {
            print_r($this->request->getData());
            /*$cargo = $this->Cargos->patchEntity($cargo, $this->request->getData());
            if ($this->Cargos->save($cargo)) {
                $this->Flash->success(__('The cargo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cargo could not be saved. Please, try again.'));*/
        }
        $orAccounts = [];
        foreach ($this->paidAccountIds as $id) $orAccounts = array_merge($orAccounts, ['id' => $id]);

        $accounts = $this->Cargos->Accounts->find('list', [
            'keyField' => 'id',
            'valueField' => 'username'
        ])
                         ->where(['OR' => $orAccounts])
                         ->toArray();

        $this->set(compact('cargo', 'accounts'));
        $this->set('user', $this->user);
        //$this->set('accounts', $this->paidAccounts);
    }

    /**
     * Edit method
     *
     * @param string|null $id Cargo id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $cargo = $this->Cargos->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $cargo = $this->Cargos->patchEntity($cargo, $this->request->getData());
            if ($this->Cargos->save($cargo)) {
                $this->Flash->success(__('The cargo has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The cargo could not be saved. Please, try again.'));
        }
        $accounts = $this->Cargos->Accounts->find('list', ['limit' => 200]);
        $this->set(compact('cargo', 'accounts'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Cargo id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $cargo = $this->Cargos->get($id);
        if ($this->Cargos->delete($cargo)) {
            $this->Flash->success(__('The cargo has been deleted.'));
        } else {
            $this->Flash->error(__('The cargo could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
