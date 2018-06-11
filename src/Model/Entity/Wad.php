<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Wad Entity
 *
 * @property int $id
 * @property int $post_id
 * @property int $typeid
 * @property int $sequence
 * @property string $url
 * @property int $width
 * @property int $height
 * @property bool $urlfixed
 * @property bool $active
 *
 * @property \App\Model\Entity\Post $post
 */
class Wad extends Entity
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
        'post_id' => true,
        'typeid' => true,
        'sequence' => true,
        'url' => true,
        'width' => true,
        'height' => true,
        'active' => true,
        'urlfixed' => true,
        'post' => true
    ];
}
