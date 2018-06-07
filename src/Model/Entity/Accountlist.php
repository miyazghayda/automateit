<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Accountlist Entity
 *
 * @property int $id
 * @property int $account_id
 * @property int $member_id
 * @property int $typeid
 * @property bool $allfollowersaved
 * @property string $nextmaxid
 * @property bool $active
 *
 * @property \App\Model\Entity\Account $account
 * @property \App\Model\Entity\Member $member
 */
class Accountlist extends Entity
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
        'member_id' => true,
        'typeid' => true,
        'allfollowersaved' => true,
        'nextmaxid' => true,
        'active' => true,
        'account' => true,
        'member' => true
    ];
}
