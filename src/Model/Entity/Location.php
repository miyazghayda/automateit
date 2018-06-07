<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Location Entity
 *
 * @property int $id
 * @property int $pk
 * @property float $lat
 * @property float $lng
 * @property string $address
 * @property string $name
 * @property string $shortname
 * @property bool $active
 *
 * @property \App\Model\Entity\Post[] $posts
 */
class Location extends Entity
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
        'lat' => true,
        'lng' => true,
        'address' => true,
        'name' => true,
        'shortname' => true,
        'active' => true,
        'posts' => true
    ];
}
