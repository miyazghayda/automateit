<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Members Model
 *
 * @property \App\Model\Table\FollowinglistsTable|\Cake\ORM\Association\HasMany $Followinglists
 * @property \App\Model\Table\LikinglistsTable|\Cake\ORM\Association\HasMany $Likinglists
 * @property \App\Model\Table\PostsTable|\Cake\ORM\Association\HasMany $Posts
 * @property \App\Model\Table\VassalsTable|\Cake\ORM\Association\HasMany $Vassals
 * @property \App\Model\Table\CommentinglistsTable|\Cake\ORM\Association\HasMany $Commentinglists
 * @property \App\Model\Table\AccountlistsTable|\Cake\ORM\Association\HasMany $Accountlists
 *
 * @method \App\Model\Entity\Member get($primaryKey, $options = [])
 * @method \App\Model\Entity\Member newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Member[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Member|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Member|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Member patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Member[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Member findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class MembersTable extends Table
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

        $this->setTable('members');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->hasMany('Followinglists', [
            'foreignKey' => 'member_id'
        ]);
        $this->hasMany('Likinglists', [
            'foreignKey' => 'member_id'
        ]);
        $this->hasMany('Posts', [
            'foreignKey' => 'member_id'
        ]);
        $this->hasMany('Vassals', [
            'foreignKey' => 'member_id'
        ]);
        $this->hasMany('Accountlists', [
            'foreignKey' => 'account_id'
        ]);
        $this->hasMany('Commentinglists', [
            'foreignKey' => 'account_id'
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
            ->maxLength('profpicurl', 1000)
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
            ->boolean('profpicurlfixed')
            ->allowEmpty('profpicurlfixed');

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
