<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FollowinglistsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FollowinglistsTable Test Case
 */
class FollowinglistsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FollowinglistsTable
     */
    public $Followinglists;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.followinglists',
        'app.vassals',
        'app.members',
        'app.fellows',
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
        $config = TableRegistry::getTableLocator()->exists('Followinglists') ? [] : ['className' => FollowinglistsTable::class];
        $this->Followinglists = TableRegistry::getTableLocator()->get('Followinglists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Followinglists);

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
