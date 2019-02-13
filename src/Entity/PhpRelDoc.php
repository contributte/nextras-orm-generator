<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Entity;

use Contributte\Nextras\Orm\Generator\Utils\DocBuilder;
use InvalidArgumentException;

class PhpRelDoc
{

	/**
	 * Order directions
	 */

	public const ASC = 1;
	public const DESC = 2;

	/** @var string */
	private $type;

	/** @var string */
	private $entity;

	/** @var string */
	private $variable;

	/** @var bool */
	private $primary;

	/** @var string */
	private $orderProperty;

	/** @var int */
	private $orderDirection;

	public function getType(): string
	{
		return $this->type;
	}

	public function setType(string $type): void
	{
		$this->type = $type;
	}

	public function getEntity(): string
	{
		return $this->entity;
	}

	public function setEntity(string $entity): void
	{
		$this->entity = $entity;
	}

	public function getVariable(): string
	{
		return $this->variable;
	}

	public function setVariable(string $variable): void
	{
		$this->variable = $variable;
	}

	public function isPrimary(): bool
	{
		return $this->primary;
	}

	public function setPrimary(bool $primary): void
	{
		$this->primary = (bool) $primary;
	}

	public function getOrderProperty(): string
	{
		return $this->orderProperty;
	}

	public function setOrderProperty(string $orderProperty): void
	{
		$this->orderProperty = $orderProperty;
	}

	public function getOrderDirection(): int
	{
		return $this->orderDirection;
	}

	public function setOrderDirection(int $direction): void
	{
		if (in_array($direction, [self::ASC, self::DESC])) {
			throw new InvalidArgumentException('Unknown order direction ' . $direction);
		}

		$this->orderDirection = $direction;
	}

	public function __toString(): string
	{
		$b = new DocBuilder();

		// Type (1:m, m:1, m:n, etc..)
		$b->append($this->type);

		// Entity and variable (Entity::$variable)
		if ($this->variable) {
			$b->str(ucfirst($this->entity));
			$b->str('::');
			$b->append('$' . $this->variable);
		} else {
			$b->append(ucfirst($this->entity));
		}

		// Primary
		if ($this->primary) {
			$b->append('primary');
		}

		// Order (order:*property*)
		if ($this->orderProperty) {
			$b->append('order:' . $this->orderProperty);
		}

		// Ordering (DESC/ASC)
		if ($this->orderDirection) {
			$b->append($this->orderDirection === self::ASC ? 'ASC' : 'DESC');
		}

		return (string) $b;
	}

}
