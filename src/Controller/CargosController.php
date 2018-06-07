<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\I18n\Time;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

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
            array_push($orAccounts, ['account_id' => $account['id']]);
            //$orAccounts = array_merge($orAccounts, ['account_id' => $account['id']]);
            array_push($paidAccountIds, $account['id']);
        }
        $this->orAccounts = $orAccounts;
        $this->paidAccountIds = $paidAccountIds;

        $this->loadComponent('CakephpJqueryFileUpload.JqueryFileUpload');
        $this->loadComponent('RequestHandler');
    }

    public function isAuthorized($user) {
        $action = $this->request->getParam('action');

        // All actions require an id
        $id = $this->request->getParam('pass.0');
        if (!$id) {
            return false;
        }

        // Check that the cargo belongs to the current user.
        $cargo = $this->Cargos->findById($id)->first();

        if (in_array($cargo->account_id, $this->paidAccountIds)) {
            return true;
        } else {
            return false;
        }
    }

    public function queue($id = null) {
        $this->set('user', $this->user);

        $orAccounts = $this->orAccounts;
        // If id specified
        if ($id > 0 && in_array($id, $this->paidAccountIdss)) $orAccounts = ['account_id' => $id];

        if (count($orAccounts) > 0) {
            $cargos = $this->Cargos->find()
                           ->where(['uploaded' => false, 'active' => 1, 'OR' => $orAccounts])
                           ->order(['schedule' => 'ASC'])
                           ->contain(['reaps'])
                           ->all();
        } else {
            $cargos = [];
        }

        $imagePath = DS . 'files' . DS . 'images' . DS . 'upload' . DS;
        $this->set(compact('cargos', 'imagePath'));
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
    }

    private function rename($filename, $id) {
        $file = new File(WWW_ROOT . 'files' . DS . 'images' . DS . 'upload' . DS . $filename, false, 0755);
        $file->copy(WWW_ROOT . 'files' . DS . 'images' . DS . 'upload' . DS . $id . '.' . $file->ext(), true);
        $file->delete();
        $file->close();

        $thumbnail = new File(WWW_ROOT . 'files' . DS . 'images' . DS . 'upload' . DS . 'thumbnail' . DS . $filename, false, 0755);
        $thumbnail->copy(WWW_ROOT . 'files' . DS . 'images' . DS . 'upload' . DS . 'thumbnail' . DS . $id . '.' . $thumbnail->ext(), true);
        $thumbnail->delete();
        $thumbnail->close();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index($id = null)
    {
        $orAccounts = $this->orAccounts;
        // If id specified
        if ($id > 0 && in_array($id, $this->paidAccountIdss)) $orAccounts = ['account_id' => $id];

        if (count($orAccounts) > 0) {
            $cargos = $this->Cargos->find()
                           ->where(['uploaded' => true, 'active' => 1, 'OR' => $orAccounts])
                           ->order(['schedule' => 'DESC'])
                           ->contain(['reaps'])
                           ->all();
        } else {
            $cargos = [];
        }

        $imagePath = DS . 'files' . DS . 'images' . DS . 'upload' . DS;
        $this->set(compact('cargos', 'imagePath'));
        $this->set('user', $this->user);
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
        if (!$this->isAuthorized($this->user)) {
            $this->redirect(['action' => 'queue']);
        }

        $cargo = $this->Cargos->get($id, [
            'contain' => ['Reaps', 'Accounts']
        ]);

        $imagePath = DS . 'files' . DS . 'images' . DS . 'upload' . DS;

        $this->set('user', $this->user);
        $this->set(compact('cargo', 'imagePath'));
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
            $data = $this->request->getData();
            $data['reaps'] = explode(',', $data['reaps']);
            $data['typeid'] = 1;// Photo
            $data['uploaded'] = false;
            $data['active'] = true;

            if (count($data['reaps']) < 1) $this->Flash->error(__('Pilih minimal 1 file.'));
            if (count($data['reaps']) > 1) $data['typeid'] = 3;// Carousel
            if(!empty($data['schedule'])) {
                $data['schedule'] = Time::createFromFormat('Y-m-d H:i:s', $data['schedule'], 'Asia/Jakarta')->i18nFormat('yyyy-MM-dd HH:mm:ss');
            }

            $cargo = $this->Cargos->patchEntity($cargo, $data);
            if ($this->Cargos->save($cargo)) {
                // Save to reaps table
                $cargo_id = $cargo->id;
                $sequence = 0;
                foreach ($data['reaps'] as $r) {
                    $dataReap = [
                        'cargo_id' => $cargo->id,
                        'typeid' => 1,
                        'extension' => pathinfo($r, PATHINFO_EXTENSION),
                        'sequence' => $sequence,
                        'active' => true
                    ];
                    $reap = $this->Cargos->Reaps->newEntity();
                    $reap = $this->Cargos->Reaps->patchEntity($reap, $dataReap);
                    if ($this->Cargos->Reaps->save($reap)) $this->rename($r, $reap->id);
                    $sequence++;
                }
                $this->Flash->success(__('Konten berhasil ditambahkan.'));

                return $this->redirect(['action' => 'queue']);
            }
            $this->Flash->error(__('Ups, terjadi kesalahan. Silahkan mengulangi.'));
        }
        $orAccounts = [];
        foreach ($this->paidAccountIds as $id) array_push($orAccounts, ['id' => $id]);

        if (count($orAccounts) > 0) {
            $accounts = $this->Cargos->Accounts->find('list', [
                'keyField' => 'id',
                'valueField' => 'username'
            ])
                             ->where(['OR' => $orAccounts])
                             ->order(['username' => 'ASC'])
                             ->toArray();

            $this->set(compact('cargo', 'accounts'));
            $this->set('user', $this->user);
        } else {
            $this->redirect(['action' => 'queue']);
        }
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
        if (!$this->isAuthorized($this->user)) {
            $this->redirect(['action' => 'queue']);
        }

        $cargo = $this->Cargos->get($id, [
            'contain' => ['Reaps', 'Accounts']
        ]);

        $imagePath = DS . 'files' . DS . 'images' . DS . 'upload' . DS;

        $this->set('user', $this->user);
        $this->set(compact('cargo', 'imagePath'));

        if ($this->request->is(['patch', 'post', 'put'])) {
            $cargo = $this->Cargos->patchEntity($cargo, $this->request->getData());
            if ($this->Cargos->save($cargo)) {
                $this->Flash->success(__('Konten berhasil diubah.'));

                return $this->redirect(['action' => 'queue']);
            }
            $this->Flash->error(__('Ups, terjadi kesalahan. Silahkan mengulangi.'));
        }
        $orAccounts = [];
        foreach ($this->paidAccountIds as $id) array_push($orAccounts, ['id' => $id]);

        if (count($orAccounts) > 0) {
            $accounts = $this->Cargos->Accounts->find('list', [
                'keyField' => 'id',
                'valueField' => 'username'
            ])
                             ->where(['OR' => $orAccounts])
                             ->order(['username' => 'ASC'])
                             ->toArray();

            $this->set('user', $this->user);
            $this->set(compact('cargo', 'imagePath', 'accounts'));
        } else {
            $this->redirect(['action' => 'queue']);
        }
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
        if (!$this->isAuthorized($this->user)) {
            $this->redirect(['action' => 'queue']);
        }

        $cargo = $this->Cargos->get($id, [
            'contain' => ['Reaps']
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = ['active' => false];
            $cargo = $this->Cargos->patchEntity($cargo, $data);
            if ($this->Cargos->save($cargo)) {
                $this->Flash->success(__('Berhasil menghapus konten.'));
            } else {
                $this->Flash->success(__('Ups! Gagal menghapus konten, silahkan mengulangi.'));
            }
            return $this->redirect(['action' => 'queue']);
        }

        $imagePath = DS . 'files' . DS . 'images' . DS . 'upload' . DS;

        $this->set('user', $this->user);
        $this->set(compact('cargo', 'imagePath'));
    }
}
