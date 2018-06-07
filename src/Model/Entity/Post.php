<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Post Entity
 *
 * @property int $id
 * @property int $pk
 * @property string $sourceid
 * @property int $location_id
 * @property int $member_id
 * @property int $likes
 * @property int $comments
 * @property int $takenat
 * @property bool $active
 *
 * @property \App\Model\Entity\Location $location
 * @property \App\Model\Entity\Member $member
 * @property \App\Model\Entity\Likinglist[] $likinglists
 */
class Post extends Entity
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
        'sourceid' => true,
        'location_id' => true,
        'member_id' => true,
        'likes' => true,
        'comments' => true,
        'takenat' => true,
        'active' => true,
        'location' => true,
        'member' => true,
        'likinglists' => true
    ];
}
