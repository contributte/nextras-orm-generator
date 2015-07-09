<?php

namespace App\Model\Entity;

use Nette\Utils\DateTime;

/**
 * @property string|NULL $fbid
 * @property string $username
 * @property string $password
 * @property string $role {enum self::ROLE_*} {default self::ROLE_USER}
 * @property DateTime $loggedAt
 * @property DateTime $createdAt
 */
class User extends AbstractEntity
{

	const ROLE_USER = 'USER';
	const ROLE_ADMIN = 'ADMIN';




}
