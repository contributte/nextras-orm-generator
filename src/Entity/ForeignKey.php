<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Entity;

class ForeignKey
{

	private string $sourceTable;

	private string $sourceColumn;

	private string $referenceTable;

	private string $referenceColumn;

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
