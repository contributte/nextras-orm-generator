<?php

namespace Minetro\Normgen\Generator\Entity\Decorator;

use Minetro\Normgen\Entity\Column;
use Minetro\Normgen\Entity\PhpDoc;
use Minetro\Normgen\Entity\PhpRelDoc;
use Minetro\Normgen\Entity\Table;
use Minetro\Normgen\Resolver\IEntityResolver;
use Minetro\Normgen\Utils\ColumnTypes;
use Minetro\Normgen\Utils\Helpers;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\PhpNamespace;
use Nette\Utils\Strings;

class ColumnDocumentor implements IDecorator
{

    /** @var IEntityResolver */
    private $resolver;

    /**
     * @param IEntityResolver $resolver
     */
    public function __construct(IEntityResolver $resolver)
    {
        $this->resolver = $resolver;
    }

    /**
     * @param PhpNamespace $namespace
     * @param ClassType $class
     * @param Column $column
     * @return void
     */
    public function doDecorate(Column $column, ClassType $class, PhpNamespace $namespace)
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
            $ftable = $column->getTable()->getDatabase()->getForeignTable($key->getReferenceTable());

            // Update type to Entity name
            $doc->setType($this->resolver->resolveEntityName($ftable));
            $doc->setRelation($relDoc = new PhpRelDoc());

            if (($use = $this->getRealUse($ftable, $namespace))) {
                $namespace->addUse($use);
            }

            $relDoc->setType('???');
            $relDoc->setEntity($this->resolver->resolveEntityName($ftable));
            $relDoc->setVariable('???');
        }

        // Append phpDoc to class
        $class->addComment((string)$column->getPhpDoc());
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
     * @param Table $table
     * @param PhpNamespace $namespace
     * @return mixed
     */
    protected function getRealUse(Table $table, PhpNamespace $namespace)
    {
        $use = $namespace->unresolveName(
            $this->resolver->resolveEntityNamespace($table) . Helpers::NS . $this->resolver->resolveEntityName($table)
        );

        if (Strings::compare($use, $table->getName())) {
            return NULL;
        }

        return $use;
    }

}