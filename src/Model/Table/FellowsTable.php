<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Fellows Model
 *
 * @property \App\Model\Table\FollowinglistsTable|\Cake\ORM\Association\HasMany $Followinglists
 * @property \App\Model\Table\VassalsTable|\Cake\ORM\Association\HasMany $Vassals
 *
 * @method \App\Model\Entity\Fellow get($primaryKey, $options = [])
 * @method \App\Model\Entity\Fellow newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Fellow[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Fellow|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Fellow|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Fellow patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Fellow[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Fellow findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class FellowsTable extends Table
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

        $this->setTable('fellows');

        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Followinglists', [
            'foreignKey' => 'fellow_id'
        ]);
        $this->hasMany('Vassals', [
            'foreignKey' => 'fellow_id'
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
            ->requirePresence('id', 'create')
            ->notEmpty('id');

        $validator
            ->requirePresence('pk', 'create')
            ->notEmpty('pk');

        $validator
            ->scalar('username')
            ->maxLength('username', 255)
            ->requirePresence('username', 'create')
            ->notEmpty('username');

        $validator
            ->scalar('fullname')
            ->maxLength('fullname', 255)
            ->requirePresence('fullname', 'create')
            ->notEmpty('fullname');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->scalar('profpicurl')
            ->maxLength('profpicurl', 255)
            ->requirePresence('profpicurl', 'create')
            ->notEmpty('profpicurl');

        $validator
            ->integer('followers')
            ->requirePresence('followers', 'create')
            ->notEmpty('followers');

        $validator
            ->integer('followings')
            ->requirePresence('followings', 'create')
            ->notEmpty('followings');

        $validator
            ->integer('contents')
            ->requirePresence('contents', 'create')
            ->notEmpty('contents');

        $validator
            ->boolean('closed')
            ->requirePresence('closed', 'create')
            ->notEmpty('closed');

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
        $rules->add($rules->isUnique(['username']));

        return $rules;
    }
}
