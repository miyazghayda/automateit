<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CommentinglistsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CommentinglistsTable Test Case
 */
class CommentinglistsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\CommentinglistsTable
     */
    public $Commentinglists;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.commentinglists',
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
        $config = TableRegistry::getTableLocator()->exists('Commentinglists') ? [] : ['className' => CommentinglistsTable::class];
        $this->Commentinglists = TableRegistry::getTableLocator()->get('Commentinglists', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Commentinglists);

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
