<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LikinglistsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LikinglistsTable Test Case
 */
class LikinglistsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\LikinglistsTable
     */
    public $Likinglists;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.likinglists',
        'app.accounts',
        'app.members',
        'app.posts'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Likinglists') ? [] : ['className' => LikinglistsTable::class];
        $this->Likinglists = TableRegistry::getTableLocator()->get('Likinglists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Likinglists);

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
