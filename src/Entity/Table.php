<?php

namespace Minetro\Normgen\Entity;

use InvalidArgumentException;
use Minetro\Normgen\Exception\InvalidAttachException;

class Table
{

    /** @var Database */
    private $database;

    /** @var string */
    private $name;

    /** @var Column[] */
    private $columns = [];

    /**
     * @param Database $database
     */
    public function attach(Database $database)
    {
        if ($this->database) {
            throw new InvalidAttachException('Table is already attached to database.');
        }

        $this->database = $database;
    }

    /**
     * @return Database
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @return Column[]
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param string $name
     * @return Column
     */
    public function getColumn($name)
    {
        if (!isset($this->columns[$name])) {
            throw new InvalidArgumentException("Uknown column $name");
        }

        return $this->columns[$name];
    }

    /**
     * @param Column $column
     */
    public function addColumn(Column $column)
    {
        $column->attach($this);
        $this->columns[$column->getName()] = $column;
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


}
