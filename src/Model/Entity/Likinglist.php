<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Likinglist Entity
 *
 * @property int $id
 * @property int $account_id
 * @property int $member_id
 * @property int $post_id
 * @property int $typeid
 * @property bool $liked
 * @property bool $unliked
 * @property \Cake\I18n\FrozenTime $likedat
 * @property \Cake\I18n\FrozenTime $unlikedat
 * @property bool $who
 * @property string $note
 * @property bool $active
 *
 * @property \App\Model\Entity\Account $account
 * @property \App\Model\Entity\Member $member
 * @property \App\Model\Entity\Post $post
 */
class Likinglist extends Entity
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
        'liked' => true,
        'unliked' => true,
        'likedat' => true,
        'unlikedat' => true,
        'who' => true,
        'note' => true,
        'active' => true,
        'account' => true,
        'member' => true,
        'post' => true
    ];
}
