<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Entity;

use Contributte\Nextras\Orm\Generator\Exception\InvalidStateException;

class Database
{

	/** @var Table[] */
	private $tables = [];

	/**
	 * @return Table[]
	 */
	public function getTables(): array
	{
		return $this->tables;
	}

	public function addTable(Table $table): void
	{
		$table->attach($this);
		$this->tables[] = $table;
	}

	public function getForeignTable(string $name): Table
	{
		foreach ($this->tables as $table) {
			if ($name === $table->getName()) {
				return $table;
			}
		}

		throw new InvalidStateException('Foreign table not found. Please review analyser.');
	}

}
