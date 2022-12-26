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
	protected $defaults = [
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
	protected $config = [];

	/**
	 * @param mixed[] $configuration
	 */
	public function __construct(array $configuration)
	{
		// Validate config
		if ($extra = array_diff_key($configuration, $this->defaults)) {
			$extra = implode(', ', array_keys($extra));
			throw new InvalidStateException('Unknown configuration option ' . $extra . '.');
		}

		$this->config = array_merge($this->defaults, $configuration);
	}

	/**
	 * MAGIC METHODS ***********************************************************
	 */

	/**
	 * @return mixed
	 */
	public function __get(string $name)
	{
		return $this->offsetGet($name);
	}

	/**
	 * @param string|mixed $name
	 * @param mixed $value
	 */
	public function __set($name, $value): void
	{
		$this->offsetSet($name, $value);
	}

	/**
	 * @return mixed
	 */
	public function get(string $name)
	{
		return $this->offsetGet($name);
	}

	/**
	 * ARRAY ACCESS ************************************************************
	 */

	/**
	 * @param mixed $offset
	 */
	public function offsetExists($offset): bool
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

	/**
	 * @param string|mixed $offset
	 * @param mixed $value
	 */
	public function offsetSet($offset, $value): void
	{
		$this->config[$offset] = $value;
	}

	/**
	 * @param mixed $offset
	 */
	public function offsetUnset($offset): void
	{
		unset($this->config[$offset]);
	}

}
