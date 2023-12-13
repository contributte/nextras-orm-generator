<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Entity;

use Contributte\Nextras\Orm\Generator\Exception\InvalidAttachException;
use LogicException;

class Column
{

	private ?Table $table = null;

	private ?string $name = null;

	private ?string $type = null;

	private ?string $subtype = null;

	private ?bool $nullable = null;

	private ?string $default = null;

	/** @var string[] */
	private array $enum = [];

	private bool $onUpdate;

	private ?PhpDoc $phpDoc = null;

	private ?bool $primary = null;

	private bool $unique;

	private bool $index;

	private ForeignKey $foreignKey;

	public function attach(Table $table): void
	{
		if ($this->table !== null) {
			throw new InvalidAttachException('Column is already attached to table.');
		}

		$this->table = $table;
	}

	public function getTable(): Table
	{
		if ($this->table === null) {
			throw new LogicException('Table is needed');
		}

		return $this->table;
	}

	public function getName(): string
	{
		if ($this->name === null) {
			throw new LogicException('Name is needed');
		}

		return $this->name;
	}

	public function setName(string $name): void
	{
		$this->name = $name;
	}

	public function getType(): string
	{
		if ($this->type === null) {
			throw new LogicException('Type is needed');
		}

		return $this->type;
	}

	public function setType(string $type): void
	{
		$this->type = $type;
	}

	public function getSubtype(): string
	{
		if ($this->subtype === null) {
			throw new LogicException('Subtype is needed');
		}

		return $this->subtype;
	}

	public function setSubtype(string $subtype): void
	{
		$this->subtype = $subtype;
	}

	public function isNullable(): ?bool
	{
		return $this->nullable;
	}

	public function setNullable(bool $nullable): void
	{
		$this->nullable = $nullable;
	}

	public function getDefault(): ?string
	{
		return $this->default;
	}

	public function setDefault(string $default): void
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
		if ($this->phpDoc === null) {
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
