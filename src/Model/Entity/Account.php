<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Account Entity
 *
 * @property int $id
 * @property int $user_id
 * @property int $proxy_id
 * @property int $pk
 * @property string $sourceid
 * @property string $username
 * @property string $fullname
 * @property string $password
 * @property string $description
 * @property int $followers
 * @property int $followings
 * @property int $posts
 * @property bool $closed
 * @property \Cake\I18n\Date $started
 * @property \Cake\I18n\Date $ended
 * @property bool $paid
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property bool $active
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\Proxy $proxy
 * @property \App\Model\Entity\Cargo[] $cargos
 * @property \App\Model\Entity\Preference[] $preferences
 */
class Account extends Entity
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
        'user_id' => true,
        'proxy_id' => true,
        'pk' => true,
        'sourceid' => true,
        'username' => true,
        'fullname' => true,
        'password' => true,
        'description' => true,
        'followers' => true,
        'followings' => true,
        'posts' => true,
        'closed' => true,
        'started' => true,
        'ended' => true,
        'paid' => true,
        'created' => true,
        'modified' => true,
        'active' => true,
        'user' => true,
        'proxy' => true,
        'cargos' => true,
        'preferences' => true
    ];

    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password'
    ];
}
