<?php

namespace Minetro\Normgen\Generator\Entity\Decorator;

use Minetro\Normgen\Entity\Column;
use Minetro\Normgen\Utils\ColumnTypes;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Nette\Utils\Strings;

class ColumnMapper implements IDecorator
{

    /**
     * @param PhpNamespace $namespace
     * @param ClassType $class
     * @param Column $column
     * @return void
     */
    public function doDecorate(Column $column, ClassType $class, PhpNamespace $namespace)
    {

        switch ($column->getType()) {

            // Map: DateTime
            case ColumnTypes::TYPE_DATETIME:
                $column->setType('DateTime');

                if ($column->getDefault() !== NULL) {
                    $column->setDefault('now');
                }

                $namespace->addUse('Nette\Utils\DateTime');
                break;

            // Map: Enum
            case ColumnTypes::TYPE_ENUM:

                foreach ($column->getEnum() as $enum) {
                    $name = Strings::upper($column->getName()) . '_' . $enum;
                    $class->addConst($name, $enum);
                }

                if ($column->getDefault() !== NULL) {
                    $column->setDefault(Strings::upper($column->getName()) . '_' . $column->getDefault());
                }

                break;
        }

    }

}