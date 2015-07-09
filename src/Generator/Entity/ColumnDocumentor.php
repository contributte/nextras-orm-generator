<?php

namespace Minetro\Normgen\Generator\Entity;

use Minetro\Normgen\Entity\Column;
use Minetro\Normgen\Entity\ForeignKey;
use Minetro\Normgen\Entity\PhpDoc;
use Minetro\Normgen\Entity\PhpRelDoc;
use Minetro\Normgen\Entity\Table;
use Minetro\Normgen\Utils\Helpers;
use Minetro\Resolver\IEntityResolver;
use Nette\InvalidStateException;
use Nette\Utils\Strings;

class ColumnDocumentor
{

    /**
     * @param Column $column
     * @param IEntityResolver $resolver
     * @return void
     */
    public function doPrepare(Column $column, IEntityResolver $resolver)
    {
        $column->setPhpDoc($doc = new PhpDoc());

        // Annotation
        $doc->setAnnotation('@property');

        // Type
        if ($column->isNullable()) {
            $doc->setType($this->getRealType($column) . '|NULL');
        } else {
            $doc->setType($this->getRealType($column));
        }

        // Variable
        $doc->setVariable(Helpers::camelCase($column->getName()));

        // Defaults
        if ($column->getDefault() !== NULL) {
            $doc->setDefault($this->getRealDefault($column));
        }

        // Enum
        if (!empty($enum = $column->getEnum())) {
            $doc->setEnum(Strings::upper($column->getName()));
        }

        // Relations
        if (($key = $column->getForeignKey()) !== NULL) {
            // Find foreign entity table
            $ftable = $this->getForeignEntityName($column, $key);

            // Update type to Entity name
            $doc->setType($resolver->resolveEntityName($ftable));
            $doc->setRelation($relDoc = new PhpRelDoc());

            $relDoc->setType('???');
            $relDoc->setEntity($resolver->resolveEntityName($ftable));
            $relDoc->setVariable('???');
        }
    }

    public function doDocument(Column $column)
    {
        return (string)$column->getPhpDoc();
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


    /**
     * @param Column $column
     * @param ForeignKey $key
     * @return Table
     */
    protected function getForeignEntityName(Column $column, ForeignKey $key)
    {
        $tables = $column->getTable()->getDatabase()->getTables();

        foreach ($tables as $table) {
            if ($key->getReferenceTable() === $table->getName()) {
                return $table;
            }
        }

        throw new InvalidStateException('Foreign table not found. Please review analyser.');
    }

}