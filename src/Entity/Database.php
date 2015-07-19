<?php

namespace Minetro\Normgen\Entity;

use Minetro\Normgen\Exception\InvalidStateException;

class Database
{

    /** @var Table[] */
    private $tables = [];

    /**
     * @return Table[]
     */
    public function getTables()
    {
        return $this->tables;
    }

    /**
     * @param Table $table
     */
    public function addTable(Table $table)
    {
        $table->attach($this);
        $this->tables[] = $table;
    }

    /**
     * @param Column $column
     * @param ForeignKey $key
     * @return Table
     */
    public function getForeignTable($name)
    {
        foreach ($this->tables as $table) {
            if ($name === $table->getName()) {
                return $table;
            }
        }

        throw new InvalidStateException('Foreign table not found. Please review analyser.');
    }
}
