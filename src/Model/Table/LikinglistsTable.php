<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Likinglists Model
 *
 * @property \App\Model\Table\AccountsTable|\Cake\ORM\Association\BelongsTo $Accounts
 * @property \App\Model\Table\MembersTable|\Cake\ORM\Association\BelongsTo $Members
 * @property \App\Model\Table\PostsTable|\Cake\ORM\Association\BelongsTo $Posts
 *
 * @method \App\Model\Entity\Likinglist get($primaryKey, $options = [])
 * @method \App\Model\Entity\Likinglist newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Likinglist[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Likinglist|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Likinglist|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Likinglist patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Likinglist[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Likinglist findOrCreate($search, callable $callback = null, $options = [])
 */
class LikinglistsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('likinglists');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Members', [
            'foreignKey' => 'member_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Posts', [
            'foreignKey' => 'post_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('typeid', 'create')
            ->notEmpty('typeid');

        $validator
            ->boolean('liked')
            ->requirePresence('liked', 'create')
            ->notEmpty('liked');

        $validator
            ->boolean('unliked')
            ->requirePresence('unliked', 'create')
            ->notEmpty('unliked');

        $validator
            ->dateTime('likedat')
            ->allowEmpty('likedat');

        $validator
            ->dateTime('unlikedat')
            ->allowEmpty('unlikedat');

        $validator
            ->boolean('who')
            ->requirePresence('who', 'create')
            ->notEmpty('who');

        $validator
            ->scalar('note')
            ->requirePresence('note', 'create')
            ->notEmpty('note');

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmpty('active');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['account_id'], 'Accounts'));
        $rules->add($rules->existsIn(['member_id'], 'Members'));
        $rules->add($rules->existsIn(['post_id'], 'Posts'));

        return $rules;
    }
}
