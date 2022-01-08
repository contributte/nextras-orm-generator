<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Entity;

use Contributte\Nextras\Orm\Generator\Exception\InvalidAttachException;
use InvalidArgumentException;
use LogicException;

class Table
{

	/** @var Database|null */
	private $database;

	/** @var string */
	private $name;

	/** @var Column[] */
	private $columns = [];

	public function attach(Database $database): void
	{
		if ($this->database) {
			throw new InvalidAttachException('Table is already attached to database.');
		}

		$this->database = $database;
	}

	public function getDatabase(): Database
	{
		if (!$this->database) {
			throw new LogicException('Database is needed');
		}

		return $this->database;
	}

	/**
	 * @return Column[]
	 */
	public function getColumns(): array
	{
		return $this->columns;
	}

	public function getColumn(string $name): Column
	{
		if (!isset($this->columns[$name])) {
			throw new InvalidArgumentException('Uknown column ' . $name);
		}

		return $this->columns[$name];
	}

	/**
	 * @return Column[]
	 */
	public function getPrimaryKeyColumns(): array
	{
		$primary = [];
		foreach ($this->columns as $column) {
			if ($column->isPrimary()) {
				$primary[] = $column;
			}
		}

		return $primary;
	}

	public function addColumn(Column $column): void
	{
		$column->attach($this);
		$this->columns[$column->getName()] = $column;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}

}
