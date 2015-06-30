<?php

namespace Minetro\Normgen\Entity;

use InvalidArgumentException;

class Table
{

    /** @var string */
    private $name;

    /** @var Column[] */
    private $columns = [];

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
