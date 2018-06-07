<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FellowsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FellowsTable Test Case
 */
class FellowsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\FellowsTable
     */
    public $Fellows;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.fellows',
        'app.followinglists',
        'app.vassals'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Fellows') ? [] : ['className' => FellowsTable::class];
        $this->Fellows = TableRegistry::getTableLocator()->get('Fellows', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Fellows);

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
