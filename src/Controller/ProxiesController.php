<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Proxies Controller
 *
 * @property \App\Model\Table\ProxiesTable $Proxies
 *
 * @method \App\Model\Entity\Proxy[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProxiesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $proxies = $this->paginate($this->Proxies);

        $this->set(compact('proxies'));
    }

    /**
     * View method
     *
     * @param string|null $id Proxy id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $proxy = $this->Proxies->get($id, [
            'contain' => ['Accounts']
        ]);

        $this->set('proxy', $proxy);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $proxy = $this->Proxies->newEntity();
        if ($this->request->is('post')) {
            $proxy = $this->Proxies->patchEntity($proxy, $this->request->getData());
            if ($this->Proxies->save($proxy)) {
                $this->Flash->success(__('The proxy has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The proxy could not be saved. Please, try again.'));
        }
        $this->set(compact('proxy'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Proxy id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $proxy = $this->Proxies->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $proxy = $this->Proxies->patchEntity($proxy, $this->request->getData());
            if ($this->Proxies->save($proxy)) {
                $this->Flash->success(__('The proxy has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The proxy could not be saved. Please, try again.'));
        }
        $this->set(compact('proxy'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Proxy id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $proxy = $this->Proxies->get($id);
        if ($this->Proxies->delete($proxy)) {
            $this->Flash->success(__('The proxy has been deleted.'));
        } else {
            $this->Flash->error(__('The proxy could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
