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
class DocumentationController extends AppController
{
    public $user;

    public function initialize() {
        parent::initialize();
        $this->user = $this->Auth->user();
    }

    public function faq() {
        $this->set('user', $this->user);
    }
}
