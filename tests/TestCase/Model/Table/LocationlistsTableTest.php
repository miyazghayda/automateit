<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocationlistsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocationlistsTable Test Case
 */
class LocationlistsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LocationlistsTable
     */
    public $Locationlists;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.locationlists',
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
        $config = TableRegistry::getTableLocator()->exists('Locationlists') ? [] : ['className' => LocationlistsTable::class];
        $this->Locationlists = TableRegistry::getTableLocator()->get('Locationlists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Locationlists);

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
