<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Entity;

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

	public function getSourceTable(): string
	{
		return $this->sourceTable;
	}

	public function setSourceTable(string $sourceTable): void
	{
		$this->sourceTable = $sourceTable;
	}

	public function getSourceColumn(): string
	{
		return $this->sourceColumn;
	}

	public function setSourceColumn(string $sourceColumn): void
	{
		$this->sourceColumn = $sourceColumn;
	}

	public function getReferenceTable(): string
	{
		return $this->referenceTable;
	}

	public function setReferenceTable(string $referenceTable): void
	{
		$this->referenceTable = $referenceTable;
	}

	public function getReferenceColumn(): string
	{
		return $this->referenceColumn;
	}

	public function setReferenceColumn(string $referenceColumn): void
	{
		$this->referenceColumn = $referenceColumn;
	}

}
