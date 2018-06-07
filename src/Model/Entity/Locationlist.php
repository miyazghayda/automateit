<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Locationlist Entity
 *
 * @property int $id
 * @property int $account_id
 * @property bool $whitelist
 * @property string $caption
 * @property int $typeid
 * @property bool $active
 *
 * @property \App\Model\Entity\Account $account
 */
class Locationlist extends Entity
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
        'whitelist' => true,
        'caption' => true,
        'typeid' => true,
        'active' => true,
        'account' => true
    ];
}
