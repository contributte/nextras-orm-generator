<?php

namespace Contributte\Nextras\Orm\Generator\Entity;

use Contributte\Nextras\Orm\Generator\Exception\InvalidAttachException;

class Column
{

    /** @var Table */
    private $table;

    /** @var string */
    private $name;

    /** @var mixed */
    private $type;

    /** @var mixed */
    private $subtype;

    /** @var bool */
    private $nullable;

    /** @var mixed */
    private $default;

    /** @var array */
    private $enum = [];

    /** @var bool */
    private $onUpdate;

    /** @var PhpDoc */
    private $phpDoc;

    /** @var bool */
    private $primary;

    /** @var bool */
    private $unique;

    /** @var bool */
    private $index;

    /** @var ForeignKey */
    private $foreignKey;

    /**
     * @param Table $table
     */
    public function attach(Table $table)
    {
        if ($this->table) {
            throw new InvalidAttachException('Column is already attached to table.');
        }

        $this->table = $table;
    }

    /**
     * @return Table
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getSubtype()
    {
        return $this->subtype;
    }

    /**
     * @param mixed $subtype
     */
    public function setSubtype($subtype)
    {
        $this->subtype = $subtype;
    }

    /**
     * @return boolean
     */
    public function isNullable()
    {
        return $this->nullable;
    }

    /**
     * @param boolean $nullable
     */
    public function setNullable($nullable)
    {
        $this->nullable = $nullable;
    }

    /**
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param mixed $default
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }

    /**
     * @return array
     */
    public function getEnum()
    {
        return $this->enum;
    }

    /**
     * @param array $enum
     */
    public function setEnum(array $enum)
    {
        $this->enum = $enum;
    }

    /**
     * @return boolean
     */
    public function isOnUpdate()
    {
        return $this->onUpdate;
    }

    /**
     * @param boolean $onUpdate
     */
    public function setOnUpdate($onUpdate)
    {
        $this->onUpdate = $onUpdate;
    }

    /**
     * @return PhpDoc
     */
    public function getPhpDoc()
    {
        if (!$this->phpDoc) {
            $this->phpDoc = new PhpDoc();
        }

        return $this->phpDoc;
    }

    /**
     * @param PhpDoc $phpDoc
     */
    public function setPhpDoc($phpDoc)
    {
        $this->phpDoc = $phpDoc;
    }

    /**
     * @return boolean
     */
    public function isPrimary()
    {
        return $this->primary;
    }

    /**
     * @param boolean $primary
     */
    public function setPrimary($primary)
    {
        $this->primary = $primary;
    }

    /**
     * @return boolean
     */
    public function isUnique()
    {
        return $this->unique;
    }

    /**
     * @param boolean $unique
     */
    public function setUnique($unique)
    {
        $this->unique = $unique;
    }

    /**
     * @return boolean
     */
    public function isIndex()
    {
        return $this->index;
    }

    /**
     * @param boolean $index
     */
    public function setIndex($index)
    {
        $this->index = $index;
    }

    /**
     * @return ForeignKey
     */
    public function getForeignKey()
    {
        return $this->foreignKey;
    }

    /**
     * @param string $sourceColumn
     * @param string $referenceTable
     * @param string $referenceColumn
     */
    public function createForeignKey($sourceColumn, $referenceTable, $referenceColumn)
    {
        $key = new ForeignKey();
        $key->setSourceColumn($sourceColumn);
        $key->setReferenceTable($referenceTable);
        $key->setReferenceColumn($referenceColumn);

        $this->foreignKey = $key;
    }

    /**
     * @param ForeignKey $foreignKey
     */
    public function setForeignKey($foreignKey)
    {
        $this->foreignKey = $foreignKey;
    }

}
