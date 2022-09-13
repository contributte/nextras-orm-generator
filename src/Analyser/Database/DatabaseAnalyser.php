<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Analyser\Database;

use Contributte\Nextras\Orm\Generator\Analyser\IAnalyser;
use Contributte\Nextras\Orm\Generator\Entity\Column;
use Contributte\Nextras\Orm\Generator\Entity\Database;
use Contributte\Nextras\Orm\Generator\Entity\ForeignKey;
use Contributte\Nextras\Orm\Generator\Entity\Table;
use Contributte\Nextras\Orm\Generator\Utils\ColumnTypes;
use Contributte\Nextras\Orm\Generator\Utils\Helpers;
use Nette\Database\Connection;
use Nette\Database\Driver;
use Nette\Utils\Strings;

class DatabaseAnalyser implements IAnalyser
{

	/** @var Connection */
	private $connection;

	/** @var Driver */
	private $driver;

	public function __construct(string $dns, string $username, ?string $password = null)
	{
		$this->connection = new Connection($dns, $username, $password);
		$this->driver = $this->connection->getDriver();
	}

	public function getConnection(): Connection
	{
		return $this->connection;
	}

	public function getDriver(): Driver
	{
		return $this->driver;
	}

	public function analyse(): Database
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

	protected function analyseColumns(Table $table): void
	{
		$tableName = $table->getName();

		// Analyse columns
		$columns = $this->driver->getColumns($tableName);

		foreach ($columns as $col) {
			$column = new Column();
			$column->setName($col['name']);
			$column->setNullable($col['nullable']);
			$column->setType(Helpers::columnType($col['nativetype']));
			$column->setDefault($col['default']);
			$column->setOnUpdate(Strings::contains($col['vendor']['extra'] ?? $col['vendor']['Extra'], 'on update'));

			// Analyse ENUM
			if ($col['nativetype'] === ColumnTypes::NATIVE_TYPE_ENUM) {
				$enum = Strings::matchAll($col['vendor']['type'] ?? $col['vendor']['Type'], ColumnTypes::NATIVE_REGEX_ENUM, PREG_PATTERN_ORDER);
				if ($enum !== []) {
					$column->setEnum($enum[1]);
					$column->setType(ColumnTypes::TYPE_ENUM);
					$column->setSubtype(Helpers::columnType($col['nativetype']));
				}
			}

			$table->addColumn($column);
		}
	}

	protected function analyseIndexes(Table $table): void
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
				$column->setIndex(true);
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
