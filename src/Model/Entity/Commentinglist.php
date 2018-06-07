<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Commentinglist Entity
 *
 * @property int $id
 * @property int $account_id
 * @property int $member_id
 * @property int $post_id
 * @property int $typeid
 * @property bool $commented
 * @property bool $uncommented
 * @property \Cake\I18n\FrozenTime $commentedat
 * @property \Cake\I18n\FrozenTime $uncommentedat
 * @property bool $who
 * @property string $caption
 * @property string $note
 * @property bool $active
 *
 * @property \App\Model\Entity\Account $account
 * @property \App\Model\Entity\Member $member
 * @property \App\Model\Entity\Post $post
 */
class Commentinglist extends Entity
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
        'post_id' => true,
        'typeid' => true,
        'commented' => true,
        'uncommented' => true,
        'commentedat' => true,
        'uncommentedat' => true,
        'who' => true,
        'caption' => true,
        'note' => true,
        'active' => true,
        'account' => true,
        'member' => true,
        'post' => true
    ];
}
