<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Reap Entity
 *
 * @property int $id
 * @property int $cargo_id
 * @property int $typeid
 * @property string $extension
 * @property int $sequence
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property bool $active
 *
 * @property \App\Model\Entity\Cargo $cargo
 */
class Reap extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'cargo_id' => true,
        'typeid' => true,
        'extension' => true,
        'sequence' => true,
        'created' => true,
        'modified' => true,
        'active' => true,
        'cargo' => true
    ];
}
