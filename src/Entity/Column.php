<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Entity;

use Contributte\Nextras\Orm\Generator\Exception\InvalidAttachException;
use LogicException;

class Column
{

	/** @var Table|null */
	private $table;

	/** @var string */
	private $name;

	/** @var mixed */
	private $type;

	/** @var mixed */
	private $subtype;

	/** @var bool */
	private $nullable;

	/** @var mixed */
	private $default;

	/** @var string[] */
	private $enum = [];

	/** @var bool */
	private $onUpdate;

	/** @var PhpDoc|null */
	private $phpDoc;

	/** @var bool|null */
	private $primary;

	/** @var bool */
	private $unique;

	/** @var bool */
	private $index;

	/** @var ForeignKey */
	private $foreignKey;

	public function attach(Table $table): void
	{
		if ($this->table) {
			throw new InvalidAttachException('Column is already attached to table.');
		}

		$this->table = $table;
	}

	public function getTable(): Table
	{
		if (!$this->table) {
			throw new LogicException('Table is needed');
		}

		return $this->table;
	}

	public function getName(): string
	{
		return $this->name;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param mixed $type
	 */
	public function setType($type): void
	{
		$this->type = $type;
	}

	/**
	 * @return mixed
	 */
	public function getSubtype()
	{
		return $this->subtype;
	}

	/**
	 * @param mixed $subtype
	 */
	public function setSubtype($subtype): void
	{
		$this->subtype = $subtype;
	}

	public function isNullable(): bool
	{
		return $this->nullable;
	}

	public function setNullable(bool $nullable): void
	{
		$this->nullable = $nullable;
	}

	/**
	 * @return mixed
	 */
	public function getDefault()
	{
		return $this->default;
	}

	/**
	 * @param mixed $default
	 */
	public function setDefault($default): void
	{
		$this->default = $default;
	}

	/**
	 * @return string[]
	 */
	public function getEnum(): array
	{
		return $this->enum;
	}

	/**
	 * @param string[] $enum
	 */
	public function setEnum(array $enum): void
	{
		$this->enum = $enum;
	}

	public function isOnUpdate(): bool
	{
		return $this->onUpdate;
	}

	public function setOnUpdate(bool $onUpdate): void
	{
		$this->onUpdate = $onUpdate;
	}

	public function getPhpDoc(): PhpDoc
	{
		if (!$this->phpDoc) {
			$this->phpDoc = new PhpDoc();
		}

		return $this->phpDoc;
	}

	public function setPhpDoc(PhpDoc $phpDoc): void
	{
		$this->phpDoc = $phpDoc;
	}

	public function isPrimary(): bool
	{
		return $this->primary ?? false;
	}

	public function setPrimary(bool $primary): void
	{
		$this->primary = $primary;
	}

	public function isUnique(): bool
	{
		return $this->unique;
	}

	public function setUnique(bool $unique): void
	{
		$this->unique = $unique;
	}

	public function isIndex(): bool
	{
		return $this->index;
	}

	public function setIndex(bool $index): void
	{
		$this->index = $index;
	}

	public function getForeignKey(): ?ForeignKey
	{
		return $this->foreignKey;
	}

	public function createForeignKey(string $sourceColumn, string $referenceTable, string $referenceColumn): void
	{
		$key = new ForeignKey();
		$key->setSourceColumn($sourceColumn);
		$key->setReferenceTable($referenceTable);
		$key->setReferenceColumn($referenceColumn);

		$this->foreignKey = $key;
	}

	public function setForeignKey(ForeignKey $foreignKey): void
	{
		$this->foreignKey = $foreignKey;
	}

}
