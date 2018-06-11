<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\WadsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\WadsTable Test Case
 */
class WadsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\WadsTable
     */
    public $Wads;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.wads',
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
        $config = TableRegistry::getTableLocator()->exists('Wads') ? [] : ['className' => WadsTable::class];
        $this->Wads = TableRegistry::getTableLocator()->get('Wads', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Wads);

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
