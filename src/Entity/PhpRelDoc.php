<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Entity;

use Contributte\Nextras\Orm\Generator\Utils\DocBuilder;
use InvalidArgumentException;
use LogicException;

class PhpRelDoc
{

	public const ASC = 1;
	public const DESC = 2;

	private ?string $type;

	private ?string $entity;

	private ?string $variable;

	private ?bool $primary;

	private ?string $orderProperty;

	private ?int $orderDirection;

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

	public function getEntity(): string
	{
		if ($this->entity === null) {
			throw new LogicException('Entity is needed');
		}

		return $this->entity;
	}

	public function setEntity(string $entity): void
	{
		$this->entity = $entity;
	}

	public function getVariable(): string
	{
		if ($this->variable === null) {
			throw new LogicException('Variable is needed');
		}

		return $this->variable;
	}

	public function setVariable(string $variable): void
	{
		$this->variable = $variable;
	}

	public function isPrimary(): bool
	{
		if ($this->primary === null) {
			throw new LogicException('Primary is needed');
		}

		return $this->primary;
	}

	public function setPrimary(bool $primary): void
	{
		$this->primary = $primary;
	}

	public function getOrderProperty(): string
	{
		if ($this->orderProperty === null) {
			throw new LogicException('OrderProperty is needed');
		}

		return $this->orderProperty;
	}

	public function setOrderProperty(string $orderProperty): void
	{
		$this->orderProperty = $orderProperty;
	}

	public function getOrderDirection(): int
	{
		if ($this->orderDirection === null) {
			throw new LogicException('OrderDirection is needed');
		}

		return $this->orderDirection;
	}

	public function setOrderDirection(int $direction): void
	{
		if (in_array($direction, [self::ASC, self::DESC], true)) {
			throw new InvalidArgumentException('Unknown order direction ' . $direction);
		}

		$this->orderDirection = $direction;
	}

	public function __toString(): string
	{
		$b = new DocBuilder();

		// Type (1:m, m:1, m:n, etc..)
		$b->append($this->getType());

		// Entity and variable (Entity::$variable)
		if ($this->variable !== null) {
			$b->str(ucfirst($this->getEntity()));
			$b->str('::');
			$b->append('$' . $this->getVariable());
		} else {
			$b->append(ucfirst($this->getEntity()));
		}

		// Primary
		if ($this->primary !== null) {
			$b->append('primary');
		}

		// Order (order:*property*)
		if ($this->orderProperty !== null) {
			$b->append('order:' . $this->getOrderProperty());
		}

		// Ordering (DESC/ASC)
		if ($this->orderDirection !== null) {
			$b->append($this->getOrderDirection() === self::ASC ? 'ASC' : 'DESC');
		}

		return (string) $b;
	}

}
