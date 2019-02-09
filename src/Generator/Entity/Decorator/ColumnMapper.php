<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Generator\Entity\Decorator;

use Contributte\Nextras\Orm\Generator\Entity\Column;
use Contributte\Nextras\Orm\Generator\Utils\ColumnTypes;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Nette\Utils\Strings;

class ColumnMapper implements IDecorator
{

	public function doDecorate(Column $column, ClassType $class, PhpNamespace $namespace): void
	{
		switch ($column->getType()) {

			// Map: DateTime
			case ColumnTypes::TYPE_DATETIME:
				$column->setType('DateTimeImmutable');

				if ($column->getDefault() !== null) {
					$column->setDefault('now');
				}

				$namespace->addUse('Nextras\Dbal\Utils\DateTimeImmutable');
				break;

			// Map: Enum
			case ColumnTypes::TYPE_ENUM:
				foreach ($column->getEnum() as $enum) {
					$name = Strings::upper($column->getName()) . '_' . $enum;
					$class->addConst($name, $enum);
				}

				if ($column->getDefault() !== null) {
					$column->setDefault(Strings::upper($column->getName()) . '_' . $column->getDefault());
				}

				break;
		}
	}

}
