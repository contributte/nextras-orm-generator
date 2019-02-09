<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Analyser;

use Contributte\Nextras\Orm\Generator\Entity\Database;

interface IAnalyser
{

	public function analyse(): Database;

}
