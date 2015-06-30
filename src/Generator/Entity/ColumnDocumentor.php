<?php

namespace Minetro\Normgen\Generator\Entity;

use Minetro\Normgen\Entity\Column;
use Minetro\Normgen\Utils\Helpers;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Nette\Utils\Strings;

class ColumnDocumentor
{

    /**
     * @param PhpNamespace $namespace
     * @param ClassType $class
     * @param Column $column
     * @return string
     */
    public function document(PhpNamespace $namespace, ClassType $class, Column $column)
    {
        $doc = $column->getPhpDoc();

        // Annotation
        $doc->append('@param');

        // Type
        if ($column->isNullable()) {
            $doc->str($this->getRealType($column));
            $doc->append('|NULL');
        } else {
            $doc->append($this->getRealType($column));
        }

        // Variable
        $doc->append(sprintf('$%s', Helpers::camelCase($column->getName())));

        // Enum
        if (!empty($enum = $column->getEnum())) {
            $doc->append(sprintf('{enum self::%s_*}', Strings::upper($column->getName())));
        }

        // Defaults
        if ($column->getDefault() !== NULL) {
            $doc->append(sprintf('{default %s}', $this->getRealDefault($column)));
        }

        // Relations

        // Virtual

        return $doc;
    }

    /**
     * @param Column $column
     * @return mixed
     */
    protected function getRealType(Column $column)
    {
        switch ($column->getType()) {
            case ColumnTypes::TYPE_ENUM:
                return $column->getSubtype();
            default:
                return $column->getType();
        }
    }

    /**
     * @param Column $column
     * @return mixed
     */
    protected function getRealDefault(Column $column)
    {
        switch ($column->getType()) {
            case ColumnTypes::TYPE_ENUM:
                return 'self::' . $column->getDefault();
            default:
                return $column->getDefault();
        }
    }

}