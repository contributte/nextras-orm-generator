<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Generator;

use Contributte\Nextras\Orm\Generator\Entity\Database;

interface IGenerator
{

	public function generate(Database $database): void;

}
