<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Generator\Entity\Decorator;

use Contributte\Nextras\Orm\Generator\Config\Config;
use Contributte\Nextras\Orm\Generator\Entity\Column;
use Contributte\Nextras\Orm\Generator\Utils\Helpers;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Nette\Utils\Strings;

class ColumnConstantGenerator implements IDecorator
{

	private Config $config;

	public function __construct(Config $config)
	{
		$this->config = $config;
	}

	public function doDecorate(Column $column, ClassType $class, PhpNamespace $namespace): void
	{
		if ($this->config->getString('entity.generate.column.constant') === '') {
			return;
		}

		$name = Strings::upper($this->config->getString('entity.column.constants.prefix') . $column->getName());
		$class->addConstant($name, Helpers::camelCase($column->getName()));
	}

}
