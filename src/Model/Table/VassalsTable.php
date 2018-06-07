<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Vassals Model
 *
 * @property \App\Model\Table\MembersTable|\Cake\ORM\Association\BelongsTo $Members
 * @property \App\Model\Table\FellowsTable|\Cake\ORM\Association\BelongsTo $Fellows
 * @property \App\Model\Table\FollowinglistsTable|\Cake\ORM\Association\HasMany $Followinglists
 *
 * @method \App\Model\Entity\Vassal get($primaryKey, $options = [])
 * @method \App\Model\Entity\Vassal newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Vassal[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Vassal|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Vassal|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Vassal patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Vassal[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Vassal findOrCreate($search, callable $callback = null, $options = [])
 */
class VassalsTable extends Table
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

        $this->setTable('vassals');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Members', [
            'foreignKey' => 'member_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Fellows', [
            'foreignKey' => 'fellow_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('Followinglists', [
            'foreignKey' => 'vassal_id'
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
        $rules->add($rules->existsIn(['member_id'], 'Members'));
        $rules->add($rules->existsIn(['fellow_id'], 'Fellows'));

        return $rules;
    }
}
