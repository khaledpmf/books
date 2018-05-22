<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Book Entity
 *
 * @property int $id
 * @property string $title
 * @property string $author
 * @property \Cake\I18n\FrozenDate $released
 * @property string $img_url
 * @property string $year
 * @property \Cake\I18n\FrozenTime $happened
 */
class Book extends Entity
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
        'title' => true,
        'author' => true,
        'released' => true,
        'img_url' => true,
        'year' => true,
        'happened' => true
    ];
}
