<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Generator\Entity\Decorator;

use Contributte\Nextras\Orm\Generator\Entity\Column;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;

interface IDecorator
{

	public function doDecorate(Column $column, ClassType $class, PhpNamespace $namespace): void;

}
