<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Followinglist Entity
 *
 * @property int $id
 * @property int $vassal_id
 * @property int $member_id
 * @property int $fellow_id
 * @property int $typeid
 * @property bool $followed
 * @property bool $unfollowed
 * @property \Cake\I18n\FrozenTime $followedat
 * @property \Cake\I18n\FrozenTime $unfollowedat
 * @property bool $who
 * @property int $account_id
 * @property string $note
 * @property bool $active
 *
 * @property \App\Model\Entity\Vassal $vassal
 * @property \App\Model\Entity\Member $member
 * @property \App\Model\Entity\Fellow $fellow
 * @property \App\Model\Entity\Account $account
 */
class Followinglist extends Entity
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
        'vassal_id' => true,
        'member_id' => true,
        'fellow_id' => true,
        'typeid' => true,
        'followed' => true,
        'unfollowed' => true,
        'followedat' => true,
        'unfollowedat' => true,
        'who' => true,
        'account_id' => true,
        'note' => true,
        'active' => true,
        'vassal' => true,
        'member' => true,
        'fellow' => true,
        'account' => true
    ];
}
