<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProxiesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProxiesTable Test Case
 */
class ProxiesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\ProxiesTable
     */
    public $Proxies;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.proxies',
        'app.accounts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Proxies') ? [] : ['className' => ProxiesTable::class];
        $this->Proxies = TableRegistry::getTableLocator()->get('Proxies', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Proxies);

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
