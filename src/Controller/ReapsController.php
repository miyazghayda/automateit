<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Reaps Controller
 *
 * @property \App\Model\Table\ReapsTable $Reaps
 *
 * @method \App\Model\Entity\Reap[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ReapsController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Cargos']
        ];
        $reaps = $this->paginate($this->Reaps);

        $this->set(compact('reaps'));
    }

    /**
     * View method
     *
     * @param string|null $id Reap id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $reap = $this->Reaps->get($id, [
            'contain' => ['Cargos']
        ]);

        $this->set('reap', $reap);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $reap = $this->Reaps->newEntity();
        if ($this->request->is('post')) {
            $reap = $this->Reaps->patchEntity($reap, $this->request->getData());
            if ($this->Reaps->save($reap)) {
                $this->Flash->success(__('The reap has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reap could not be saved. Please, try again.'));
        }
        $cargos = $this->Reaps->Cargos->find('list', ['limit' => 200]);
        $this->set(compact('reap', 'cargos'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Reap id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $reap = $this->Reaps->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $reap = $this->Reaps->patchEntity($reap, $this->request->getData());
            if ($this->Reaps->save($reap)) {
                $this->Flash->success(__('The reap has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The reap could not be saved. Please, try again.'));
        }
        $cargos = $this->Reaps->Cargos->find('list', ['limit' => 200]);
        $this->set(compact('reap', 'cargos'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Reap id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $reap = $this->Reaps->get($id);
        if ($this->Reaps->delete($reap)) {
            $this->Flash->success(__('The reap has been deleted.'));
        } else {
            $this->Flash->error(__('The reap could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
