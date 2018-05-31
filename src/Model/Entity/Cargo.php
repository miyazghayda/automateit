<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Cargo Entity
 *
 * @property int $id
 * @property int $account_id
 * @property int $typeid
 * @property \Cake\I18n\FrozenTime $schedule
 * @property bool $uploaded
 * @property string $caption
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property bool $active
 *
 * @property \App\Model\Entity\Account $account
 * @property \App\Model\Entity\Reap[] $reaps
 */
class Cargo extends Entity
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
        'account_id' => true,
        'typeid' => true,
        'schedule' => true,
        'uploaded' => true,
        'caption' => true,
        'created' => true,
        'modified' => true,
        'active' => true,
        'account' => true,
        'reaps' => true
    ];
}
