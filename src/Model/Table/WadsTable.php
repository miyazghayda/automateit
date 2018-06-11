<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Wads Model
 *
 * @property \App\Model\Table\PostsTable|\Cake\ORM\Association\BelongsTo $Posts
 *
 * @method \App\Model\Entity\Wad get($primaryKey, $options = [])
 * @method \App\Model\Entity\Wad newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Wad[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Wad|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Wad|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Wad patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Wad[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Wad findOrCreate($search, callable $callback = null, $options = [])
 */
class WadsTable extends Table
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

        $this->setTable('wads');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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
            ->requirePresence('sequence', 'create')
            ->notEmpty('sequence');

        $validator
            ->scalar('url')
            ->maxLength('url', 1000)
            ->requirePresence('url', 'create')
            ->notEmpty('url');

        $validator
            ->requirePresence('width', 'create')
            ->notEmpty('width');

        $validator
            ->requirePresence('height', 'create')
            ->notEmpty('height');

        $validator
            ->boolean('urlfixed')
            ->allowEmpty('urlfixed');

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
        $rules->add($rules->existsIn(['post_id'], 'Posts'));

        return $rules;
    }
}
