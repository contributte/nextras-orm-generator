<?php

namespace Minetro\Normgen\Generator\Entity;

use Minetro\Normgen\Entity\Column;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Nette\Utils\Strings;

class ColumnMapper
{

    /**
     * @param PhpNamespace $namespace
     * @param ClassType $class
     * @param Column $column
     */
    public function doMapping(PhpNamespace $namespace, ClassType $class, Column $column)
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