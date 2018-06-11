<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Locations Model
 *
 * @property \App\Model\Table\PostsTable|\Cake\ORM\Association\HasMany $Posts
 *
 * @method \App\Model\Entity\Location get($primaryKey, $options = [])
 * @method \App\Model\Entity\Location newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Location[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Location|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Location|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Location patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Location[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Location findOrCreate($search, callable $callback = null, $options = [])
 */
class LocationsTable extends Table
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

        $this->setTable('locations');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Posts', [
            'foreignKey' => 'location_id'
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
            ->integer('fbplacesid')
            ->allowEmpty('fbplacesid');

        $validator
            ->decimal('lat')
            ->requirePresence('lat', 'create')
            ->notEmpty('lat');

        $validator
            ->decimal('lng')
            ->requirePresence('lng', 'create')
            ->notEmpty('lng');

        $validator
            ->scalar('address')
            ->allowEmpty('address');

        $validator
            ->scalar('name')
            ->requirePresence('name', 'create')
            ->notEmpty('name');

        $validator
            ->scalar('shortname')
            ->maxLength('shortname', 255)
            ->allowEmpty('shortname');
            //->requirePresence('shortname', 'create')
            //->notEmpty('shortname');

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmpty('active');

        return $validator;
    }
}
