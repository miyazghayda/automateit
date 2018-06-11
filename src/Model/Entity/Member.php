<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Member Entity
 *
 * @property int $id
 * @property int $pk
 * @property string $username
 * @property string $fullname
 * @property string $description
 * @property string $profpicurl
 * @property int $followers
 * @property int $followings
 * @property int $contents
 * @property bool $closed
 * @property bool $profpicurlfixed
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property bool $active
 *
 * @property \App\Model\Entity\Post[] $posts
 * @property \App\Model\Entity\Followinglist[] $followinglists
 * @property \App\Model\Entity\Likinglist[] $likinglists
 * @property \App\Model\Entity\Commentinglist[] $commentinglists
 * @property \App\Model\Entity\Accountlist[] $accountlists
 * @property \App\Model\Entity\Vassal[] $vassals
 */
class Member extends Entity
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
        'pk' => true,
        'username' => true,
        'fullname' => true,
        'description' => true,
        'profpicurl' => true,
        'followers' => true,
        'followings' => true,
        'contents' => true,
        'closed' => true,
        'created' => true,
        'modified' => true,
        'active' => true,
        'profpicurlfixed' => true,
        'followinglists' => true,
        'likinglists' => true,
        'vassals' => true
    ];
}
