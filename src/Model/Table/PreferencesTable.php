<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Preferences Model
 *
 * @property \App\Model\Table\AccountsTable|\Cake\ORM\Association\BelongsTo $Accounts
 *
 * @method \App\Model\Entity\Preference get($primaryKey, $options = [])
 * @method \App\Model\Entity\Preference newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Preference[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Preference|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Preference|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Preference patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Preference[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Preference findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PreferencesTable extends Table
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

        $this->setTable('preferences');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

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
            ->integer('maxlikeperday')
            ->requirePresence('maxlikeperday', 'create')
            ->notEmpty('maxlikeperday');

        $validator
            ->integer('maxcommentperday')
            ->requirePresence('maxcommentperday', 'create')
            ->notEmpty('maxcommentperday');

        $validator
            ->integer('maxfollowperday')
            ->requirePresence('maxfollowperday', 'create')
            ->notEmpty('maxfollowperday');

        $validator
            ->integer('maxpostperday')
            ->requirePresence('maxpostperday', 'create')
            ->notEmpty('maxpostperday');

        $validator
            ->integer('hashtagtofollowtoday')
            ->allowEmpty('hashtagtofollowtoday');

        $validator
            ->boolean('gethashtagtofollowtoday')
            ->allowEmpty('gethashtagtofollowtoday');

        $validator
            ->integer('followtoday')
            ->allowEmpty('followtoday');

        $validator
            ->integer('liketoday')
            ->allowEmpty('liketoday');

        $validator
            ->integer('commenttoday')
            ->allowEmpty('commenttoday');

        $validator
            ->integer('posttoday')
            ->allowEmpty('posttoday');

        $validator
            ->boolean('followidolfollower')
            ->allowEmpty('followidolfollower');

        $validator
            ->boolean('followbyhashtag')
            ->allowEmpty('followbyhashtag');

        $validator
            ->boolean('followbylocation')
            ->allowEmpty('followbylocation');

        $validator
            ->boolean('likefeed')
            ->allowEmpty('likefeed');

        $validator
            ->boolean('likebyhashtag')
            ->allowEmpty('likebyhashtag');

        $validator
            ->boolean('likebylocation')
            ->allowEmpty('likebylocation');

        $validator
            ->boolean('commentfeed')
            ->allowEmpty('commentfeed');

        $validator
            ->boolean('commentbyhashtag')
            ->allowEmpty('commentbyhashtag');

        $validator
            ->boolean('commentbylocation')
            ->allowEmpty('commentbylocation');

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

        return $rules;
    }
}
