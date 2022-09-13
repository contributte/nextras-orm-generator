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
			case ColumnTypes::TYPE_DATE:
				$column->setType('DateTimeImmutable');

				if ($column->getDefault() !== null) {
					$defaultValue = $column->getType() === ColumnTypes::TYPE_DATE ? 'today' : 'now';
					$column->setDefault($defaultValue);
				}

				$namespace->addUse('Nextras\Dbal\Utils\DateTimeImmutable');
				break;

			// Map: Enum
			case ColumnTypes::TYPE_ENUM:
				foreach ($column->getEnum() as $enum) {
					// Replace all character which are not in Helpers::PHP_IDENT
					$enum = Strings::replace($enum, '/[^a-zA-Z0-9_\x7f-\xff]*/', '');
					$enum = Strings::upper($enum);
					$name = Strings::upper($column->getName()) . '_' . $enum;
					$class->addConstant($name, $enum);
				}

				if ($column->getDefault() !== null) {
					$column->setDefault(Strings::upper($column->getName()) . '_' . $column->getDefault());
				}

				break;
		}
	}

}
