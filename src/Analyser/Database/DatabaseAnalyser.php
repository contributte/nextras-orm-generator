<?php

namespace Minetro\Normgen\Analyser\Database;

use Minetro\Normgen\Analyser\IAnalyser;
use Minetro\Normgen\Entity\Column;
use Minetro\Normgen\Entity\Database;
use Minetro\Normgen\Entity\ForeignKey;
use Minetro\Normgen\Entity\Table;
use Minetro\Normgen\Utils\ColumnTypes;
use Minetro\Normgen\Utils\Helpers;
use Nette\Database\Connection;
use Nette\Database\ISupplementalDriver;
use Nette\Utils\Strings;

class DatabaseAnalyser implements IAnalyser
{

    /** @var Connection */
    private $connection;

    /** @var ISupplementalDriver */
    private $driver;

    /**
     * @param string $dns
     * @param string $username
     * @param string $password
     */
    function __construct($dns, $username, $password = NULL)
    {
        $this->connection = new Connection($dns, $username, $password);
        $this->driver = $this->connection->getSupplementalDriver();
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @return ISupplementalDriver
     */
    public function getDriver()
    {
        return $this->driver;
    }

    /**
     * @return Database
     */
    public function analyse()
    {
        $database = new Database();

        foreach ($this->driver->getTables() as $tArray) {

            $table = new Table();
            $table->setName($tArray['name']);

            $this->analyseColumns($table);
            $this->analyseIndexes($table);

            $database->addTable($table);
        }

        return $database;
    }

    /**
     * @param Table $table
     */
    protected function analyseColumns(Table $table)
    {
        $tableName = $table->getName();

        // Analyse columns
        $columns = $this->driver->getColumns($tableName);

        foreach ($columns as $key => $col) {

            $column = new Column();
            $column->setName($col['name']);
            $column->setNullable($col['nullable']);
            $column->setType(Helpers::columnType($col['nativetype']));
            $column->setDefault($col['default']);
            $column->setOnUpdate(Strings::contains($col['vendor']['Extra'], 'on update'));

            // Analyse ENUM
            if ($col['nativetype'] === ColumnTypes::NATIVE_TYPE_ENUM) {
                $enum = Strings::matchAll($col['vendor']['Type'], ColumnTypes::NATIVE_REGEX_ENUM, PREG_PATTERN_ORDER);
                if ($enum) {
                    $column->setEnum($enum[1]);
                    $column->setType(ColumnTypes::TYPE_ENUM);
                    $column->setSubType(Helpers::columnType($col['nativetype']));
                }
            }

            $table->addColumn($column);
        }

    }

    /**
     * @param Table $table
     */
    protected function analyseIndexes(Table $table)
    {
        $tableName = $table->getName();

        // Analyse indexes
        $indexes = $this->driver->getIndexes($tableName);
        $keys = $this->driver->getForeignKeys($tableName);

        foreach ($indexes as $index) {

            foreach ($index['columns'] as $col) {
                $column = $table->getColumn($col);

                $column->setPrimary($index['primary']);
                $column->setUnique($index['unique']);
                $column->setIndex(TRUE);
            }

        }

        foreach ($keys as $key) {
            $column = $table->getColumn($key['local']);

            $column->setForeignKey($foreign = new ForeignKey());
            $foreign->setSourceTable($table->getName());
            $foreign->setSourceColumn($key['local']);
            $foreign->setReferenceTable($key['table']);
            $foreign->setReferenceColumn($key['foreign']);
        }

    }
}
