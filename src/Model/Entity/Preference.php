<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Preference Entity
 *
 * @property int $id
 * @property int $account_id
 * @property int $maxlikeperday
 * @property int $maxfollowperday
 * @property int $maxpostperday
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property bool $active
 *
 * @property \App\Model\Entity\Account $account
 */
class Preference extends Entity
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
        'maxlikeperday' => true,
        'maxfollowperday' => true,
        'maxpostperday' => true,
        'created' => true,
        'modified' => true,
        'active' => true,
        'account' => true
    ];
}
