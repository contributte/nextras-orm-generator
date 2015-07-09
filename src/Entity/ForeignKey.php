<?php

namespace Minetro\Normgen\Entity;

class ForeignKey
{

    /** @var string */
    private $sourceTable;

    /** @var string */
    private $sourceColumn;

    /** @var string */
    private $referenceTable;

    /** @var string */
    private $referenceColumn;

    /**
     * @return string
     */
    public function getSourceTable()
    {
        return $this->sourceTable;
    }

    /**
     * @param string $sourceTable
     */
    public function setSourceTable($sourceTable)
    {
        $this->sourceTable = $sourceTable;
    }

    /**
     * @return string
     */
    public function getSourceColumn()
    {
        return $this->sourceColumn;
    }

    /**
     * @param string $sourceColumn
     */
    public function setSourceColumn($sourceColumn)
    {
        $this->sourceColumn = $sourceColumn;
    }

    /**
     * @return string
     */
    public function getReferenceTable()
    {
        return $this->referenceTable;
    }

    /**
     * @param string $referenceTable
     */
    public function setReferenceTable($referenceTable)
    {
        $this->referenceTable = $referenceTable;
    }

    /**
     * @return string
     */
    public function getReferenceColumn()
    {
        return $this->referenceColumn;
    }

    /**
     * @param string $referenceColumn
     */
    public function setReferenceColumn($referenceColumn)
    {
        $this->referenceColumn = $referenceColumn;
    }

}
