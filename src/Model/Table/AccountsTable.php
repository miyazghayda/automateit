<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Accounts Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ProxiesTable|\Cake\ORM\Association\BelongsTo $Proxies
 * @property \App\Model\Table\CargosTable|\Cake\ORM\Association\HasMany $Cargos
 * @property \App\Model\Table\PreferencesTable|\Cake\ORM\Association\HasMany $Preferences
 * @property \App\Model\Table\FollowinglistsTable|\Cake\ORM\Association\HasMany $Followinglists
 * @property \App\Model\Table\CommentinglistsTable|\Cake\ORM\Association\HasMany $Commentinglists
 * @property \App\Model\Table\LikinglistsTable|\Cake\ORM\Association\HasMany $Likinglists
 * @property \App\Model\Table\AccountlistsTable|\Cake\ORM\Association\HasMany $Accountlists
 * @property \App\Model\Table\HashtaglistsTable|\Cake\ORM\Association\HasMany $Hashtaglists
 * @property \App\Model\Table\LocationlistsTable|\Cake\ORM\Association\HasMany $Locationlists
 * @method \App\Model\Entity\Account get($primaryKey, $options = [])
 * @method \App\Model\Entity\Account newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Account[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Account|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Account|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Account patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Account[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Account findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class AccountsTable extends Table
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

        $this->setTable('accounts');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Proxies', [
            'foreignKey' => 'proxy_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Cargos', [
            'foreignKey' => 'account_id'
        ]);
        $this->hasMany('Preferences', [
            'foreignKey' => 'account_id'
        ]);
        $this->hasMany('Accountlists', [
            'foreignKey' => 'account_id'
        ]);
        $this->hasMany('Commentinglists', [
            'foreignKey' => 'account_id'
        ]);
        $this->hasMany('Followinglists', [
            'foreignKey' => 'account_id'
        ]);
        $this->hasMany('Hashtaglists', [
            'foreignKey' => 'account_id'
        ]);
        $this->hasMany('Likinglists', [
            'foreignKey' => 'account_id'
        ]);
        $this->hasMany('Locationlists', [
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
            ->scalar('profpicurl')
            ->maxLength('profpicurl', 255)
            ->allowEmpty('profpicurl');

        $validator
            ->scalar('username')
            ->maxLength('username', 255)
            ->requirePresence('username', 'create')
            ->notEmpty('username');

        $validator
            ->scalar('fullname')
            ->maxLength('fullname', 255)
            ->allowEmpty('fullname');

        $validator
            ->scalar('password')
            ->maxLength('password', 255)
            ->requirePresence('password', 'create')
            ->notEmpty('password');

        $validator
            ->scalar('description')
            ->allowEmpty('description');

        $validator
            ->integer('followers')
            ->requirePresence('followers', 'create')
            ->notEmpty('followers');

        $validator
            ->integer('followings')
            ->requirePresence('followings', 'create')
            ->notEmpty('followings');

        $validator
            ->integer('posts')
            ->requirePresence('posts', 'create')
            ->notEmpty('posts');

        $validator
            ->boolean('closed')
            ->requirePresence('closed', 'create')
            ->notEmpty('closed');

        $validator
            ->integer('statusid')
            ->allowEmpty('statusid');

        $validator
            ->scalar('note')
            ->allowEmpty('note');

        $validator
            ->date('started')
            ->allowEmpty('started');

        $validator
            ->date('ended')
            ->allowEmpty('ended');

        $validator
            ->boolean('paid')
            ->allowEmpty('paid');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['proxy_id'], 'Proxies'));

        return $rules;
    }
}
