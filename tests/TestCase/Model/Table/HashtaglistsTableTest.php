<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\HashtaglistsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\HashtaglistsTable Test Case
 */
class HashtaglistsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\HashtaglistsTable
     */
    public $Hashtaglists;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.hashtaglists',
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
        $config = TableRegistry::getTableLocator()->exists('Hashtaglists') ? [] : ['className' => HashtaglistsTable::class];
        $this->Hashtaglists = TableRegistry::getTableLocator()->get('Hashtaglists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Hashtaglists);

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
