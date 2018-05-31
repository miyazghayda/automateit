<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Proxy Entity
 *
 * @property int $id
 * @property string $name
 * @property string $username
 * @property string $password
 * @property bool $active
 *
 * @property \App\Model\Entity\Account[] $accounts
 */
class Proxy extends Entity
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
        'name' => true,
        'username' => true,
        'password' => true,
        'active' => true,
        'accounts' => true
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
