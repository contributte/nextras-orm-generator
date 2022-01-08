<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Entity;

use Contributte\Nextras\Orm\Generator\Utils\DocBuilder;

class PhpDoc
{

	/** @var string */
	private $annotation;

	/** @var string */
	private $type;

	/** @var string */
	private $variable;

	/** @var string */
	private $enum;

	/** @var string */
	private $default;

	/** @var bool */
	private $virtual;

	/** @var bool */
	private $primary;

	/** @var PhpRelDoc|null */
	private $relation;

	public function getAnnotation(): string
	{
		return $this->annotation;
	}

	public function setAnnotation(string $annotation): void
	{
		$this->annotation = $annotation;
	}

	public function getType(): string
	{
		return $this->type;
	}

	public function setType(string $type): void
	{
		$this->type = $type;
	}

	public function getVariable(): string
	{
		return $this->variable;
	}

	public function setVariable(string $variable): void
	{
		$this->variable = $variable;
	}

	public function getEnum(): string
	{
		return $this->enum;
	}

	public function setEnum(string $enum): void
	{
		$this->enum = $enum;
	}

	public function getDefault(): string
	{
		return $this->default;
	}

	public function setDefault(string $default): void
	{
		$this->default = $default;
	}

	public function isVirtual(): bool
	{
		return $this->virtual;
	}

	public function setVirtual(bool $virtual): void
	{
		$this->virtual = (bool) $virtual;
	}

	public function getRelation(): ?PhpRelDoc
	{
		return $this->relation;
	}

	public function setRelation(PhpRelDoc $relation): void
	{
		$this->relation = $relation;
	}

	public function isPrimary(): bool
	{
		return $this->primary;
	}

	public function setPrimary(bool $primary): void
	{
		$this->primary = $primary;
	}

	public function __toString(): string
	{
		$b = new DocBuilder();

		// Anotation (@..)
		if ($this->annotation) {
			$b->append($this->annotation);
		} else {
			if ($this->virtual) {
				$b->append('@property-read');
			} else {
				$b->append('@property');
			}
		}

		// Type (int, string..)
		$b->append($this->type);

		// Variable ($..)
		$b->append(sprintf('$%s', $this->variable));

		// Default
		if ($this->default) {
			$b->append(sprintf('{default %s}', $this->default));
		}

		// Enum {enum ..}
		if ($this->enum) {
			$b->append(sprintf('{enum self::%s_*}', $this->enum));
		}

		// Virtual
		if ($this->virtual) {
			$b->append('{virtual}');
		}

		if ($this->primary && $this->variable === 'id') {
			$b->append('{primary}');
		}

		// Relation
		if ($this->relation) {
			$b->append(sprintf('{%s}', (string) $this->relation));
		}

		return (string) $b;
	}

}
