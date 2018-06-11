<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Preference Entity
 *
 * @property int $id
 * @property int $account_id
 * @property int $maxlikeperday
 * @property int $maxcommentperday
 * @property int $maxfollowperday
 * @property int $maxpostperday
 * @property int $followtoday
 * @property int $liketoday
 * @property int $commenttoday
 * @property int $posttoday
 * @property int $hashtagtofollowtoday
 * @property bool $gethashtagtofollowtoday
 * @property bool $followidolfollower
 * @property bool $followbyhashtag
 * @property bool $followbylocation
 * @property bool $likefeed
 * @property bool $likebyhashtag
 * @property bool $likebylocation
 * @property bool $commentfeed
 * @property bool $commentbyhashtag
 * @property bool $commentbylocation
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property bool $active
 *
 * @property \App\Model\Entity\Account $account
 */
class Preference extends Entity
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
        'maxlikeperday' => true,
        'maxfollowperday' => true,
        'maxcommentperday' => true,
        'maxpostperday' => true,
        'created' => true,
        'modified' => true,
        'active' => true,
        'followidolfollower' => true,
        'followbyhashtag' => true,
        'followbylocation' => true,
        'likefeed' => true,
        'likebyhashtag' => true,
        'likebylocation' => true,
        'commentfeed' => true,
        'commentbyhashtag' => true,
        'commentbylocation' => true,
        'hashtagtofollowtoday' => true,
        'gethashtagtofollowtoday' => true,
        'followtoday' => true,
        'liketoday' => true,
        'commenttoday' => true,
        'posttoday' => true,
        'account' => true
    ];
}
