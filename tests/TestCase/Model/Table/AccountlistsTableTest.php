<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccountlistsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccountlistsTable Test Case
 */
class AccountlistsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AccountlistsTable
     */
    public $Accountlists;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.accountlists',
        'app.accounts',
        'app.members'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Accountlists') ? [] : ['className' => AccountlistsTable::class];
        $this->Accountlists = TableRegistry::getTableLocator()->get('Accountlists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Accountlists);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
