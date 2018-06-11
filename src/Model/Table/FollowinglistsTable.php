<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Followinglists Model
 *
 * @property \App\Model\Table\VassalsTable|\Cake\ORM\Association\BelongsTo $Vassals
 * @property \App\Model\Table\MembersTable|\Cake\ORM\Association\BelongsTo $Members
 * @property \App\Model\Table\FellowsTable|\Cake\ORM\Association\BelongsTo $Fellows
 * @property \App\Model\Table\AccountsTable|\Cake\ORM\Association\BelongsTo $Accounts
 *
 * @method \App\Model\Entity\Followinglist get($primaryKey, $options = [])
 * @method \App\Model\Entity\Followinglist newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Followinglist[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Followinglist|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Followinglist|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Followinglist patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Followinglist[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Followinglist findOrCreate($search, callable $callback = null, $options = [])
 */
class FollowinglistsTable extends Table
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

        $this->setTable('followinglists');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Vassals', [
            'foreignKey' => 'vassal_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Members', [
            'foreignKey' => 'member_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Fellows', [
            'foreignKey' => 'fellow_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Accounts', [
            'foreignKey' => 'account_id',
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
            ->boolean('followed')
            ->requirePresence('followed', 'create')
            ->notEmpty('followed');

        $validator
            ->boolean('unfollowed')
            ->requirePresence('unfollowed', 'create')
            ->notEmpty('unfollowed');

        $validator
            ->dateTime('followedat')
            ->allowEmpty('followedat');

        $validator
            ->dateTime('unfollowedat')
            ->allowEmpty('unfollowedat');

        $validator
            ->boolean('who')
            ->requirePresence('who', 'create')
            ->notEmpty('who');

        $validator
            ->scalar('note')
            ->allowEmpty('note');

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
        $rules->add($rules->existsIn(['vassal_id'], 'Vassals'));
        $rules->add($rules->existsIn(['member_id'], 'Members'));
        $rules->add($rules->existsIn(['fellow_id'], 'Fellows'));
        $rules->add($rules->existsIn(['account_id'], 'Accounts'));

        return $rules;
    }
}
