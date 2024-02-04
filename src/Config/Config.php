<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Config;

use ArrayAccess;
use Nette\InvalidStateException;

/**
 * @implements ArrayAccess<string, mixed>
 */
class Config implements ArrayAccess
{

	/**
	 * Strategy types
	 */
	public const STRATEGY_TOGETHER = 1;
	public const STRATEGY_SEPARATE = 2;

	/** @var mixed[] */
	protected array $defaults = [
		// Output folder
		'output' => null,
		// 1 => Entity + Repository + Mapper + Facade => same folder (folder = table name)
		// 2 => Entities, Repositories, Mappers, Facades => same folder for each group (folder = group name)
		'generator.generate.strategy' => null,
		// Generator
		'generator.generate.entities' => false,
		'generator.generate.repositories' => false,
		'generator.generate.mappers' => false,
		'generator.generate.facades' => false,
		'generator.generate.model' => false,
		'generator.entity.exclude.primary' => false,
		// NextrasORM
		'nextras.orm.class.entity' => 'Nextras\Orm\Entity\Entity',
		'nextras.orm.class.repository' => 'Nextras\Orm\Repository\Repository',
		'nextras.orm.class.mapper' => 'Nextras\Orm\Mapper\Mapper',
		'nextras.orm.class.model' => 'Nextras\Orm\Model\Model',
		// ORM
		'orm.namespace' => null,
		'orm.singularize' => false,
		// Entity
		'entity.folder' => null,
		'entity.namespace' => null,
		'entity.extends' => null,
		'entity.name.suffix' => null,
		'entity.name.singularize' => false,
		'entity.filename.suffix' => null,
		'entity.generate.column.constant' => false,
		'entity.generate.relations' => false,
		'entity.column.constants.prefix' => 'COL_',
		// Repository
		'repository.folder' => null,
		'repository.namespace' => null,
		'repository.extends' => null,
		'repository.name.suffix' => null,
		'repository.name.singularize' => false,
		'repository.filename.suffix' => null,
		// Mapper
		'mapper.folder' => null,
		'mapper.namespace' => null,
		'mapper.extends' => null,
		'mapper.name.suffix' => null,
		'mapper.name.singularize' => false,
		'mapper.filename.suffix' => null,
		// Facade
		'facade.folder' => null,
		'facade.namespace' => null,
		'facade.extends' => null,
		'facade.name.suffix' => null,
		'facade.name.singularize' => false,
		'facade.filename.suffix' => null,
		// model
		'model.folder' => null,
		'model.namespace' => null,
		'model.extends' => null,
		'model.name' => null,
		'model.filename' => null,

	];

	/** @var mixed[] */
	protected array $config = [];

	/**
	 * @param mixed[] $configuration
	 */
	public function __construct(array $configuration)
	{
		// Validate config
		if (($extra = array_diff_key($configuration, $this->defaults)) !== []) {
			$extra = implode(', ', array_keys($extra));

			throw new InvalidStateException('Unknown configuration option ' . $extra . '.');
		}

		$this->config = array_merge($this->defaults, $configuration);
	}

	public function get(string $name): mixed
	{
		return $this->offsetGet($name);
	}

	public function getString(string $name): string
	{
		$ret = $this->offsetGet($name);
		assert(is_string($ret));

		return $ret;
	}

	public function getStringNull(string $name): ?string
	{
		$ret = $this->offsetGet($name);
		assert(is_string($ret) || $ret === null);

		return $ret;
	}

	public function getBool(string $name): bool
	{
		$ret = $this->offsetGet($name);
		assert(is_bool($ret));

		return $ret;
	}

	public function offsetExists(mixed $offset): bool
	{
		return array_key_exists($offset, $this->config);
	}

	/**
	 * @throws InvalidStateException
	 */
	public function offsetGet(mixed $offset): mixed
	{
		if ($this->offsetExists($offset)) {
			return $this->config[$offset];
		}

		throw new InvalidStateException('Undefined offset: ' . $offset);
	}

	public function offsetSet(mixed $offset, mixed $value): void
	{
		$this->config[$offset] = $value;
	}

	public function offsetUnset(mixed $offset): void
	{
		unset($this->config[$offset]);
	}

	public function __get(string $name): mixed
	{
		return $this->offsetGet($name);
	}

	public function __set(string $name, ?string $value): void
	{
		$this->offsetSet($name, $value);
	}

}
