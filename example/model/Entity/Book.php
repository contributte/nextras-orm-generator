<?php

namespace App\Model\Entity;

use Nette\Utils\DateTime;

/**
 * @property Category $category {??? Category::$???}
 * @property User $user {??? User::$???}
 * @property Image $image {??? Image::$???}
 * @property string $name
 * @property string|NULL $author
 * @property string $description
 * @property string|NULL $publisher
 * @property int $price
 * @property int|NULL $year
 * @property int|NULL $wear
 * @property int $active
 * @property string $state {enum self::STATE_*} {default self::STATE_UNKNOWN}
 * @property DateTime $updatedAt
 * @property DateTime $createdAt
 */
class Book extends AbstractEntity
{

	const STATE_SELLING = 'SELLING';
	const STATE_SOLD = 'SOLD';
	const STATE_EXPIRED = 'EXPIRED';
	const STATE_UNKNOWN = 'UNKNOWN';




}
