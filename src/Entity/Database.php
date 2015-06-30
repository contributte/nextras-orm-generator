<?php

namespace Minetro\Normgen\Entity;

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
        $this->tables[] = $table;
    }

}
