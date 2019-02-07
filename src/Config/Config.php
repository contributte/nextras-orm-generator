<?php

namespace Contributte\Nextras\Orm\Generator\Config;

use Nette\InvalidStateException;

class Config implements \ArrayAccess
{

    /** Strategy types */
    const STRATEGY_TOGETHER = 1;
    const STRATEGY_SEPARATE = 2;

    /** @var array */
    protected $defaults = [
        // Output folder
        'output' => NULL,
        // 1 => Entity + Repository + Mapper + Facade => same folder (folder = table name)
        // 2 => Entities, Repositories, Mappers, Facades => same folder for each group (folder = group name)
        'generator.generate.strategy' => NULL,
        // Generator
        'generator.generate.entities' => FALSE,
        'generator.generate.repositories' => FALSE,
        'generator.generate.mappers' => FALSE,
        'generator.generate.facades' => FALSE,
		'generator.generate.model' => FALSE,
        'generator.entity.exclude.primary' => FALSE,
        // NextrasORM
        'nextras.orm.class.entity' => 'Nextras\Orm\Entity\Entity',
        'nextras.orm.class.repository' => 'Nextras\Orm\Repository\Repository',
        'nextras.orm.class.mapper' => 'Nextras\Orm\Mapper\Mapper',
        // ORM
        'orm.namespace' => NULL,
		'orm.singularize' => FALSE,
        // Entity
        'entity.folder' => NULL,
        'entity.namespace' => NULL,
        'entity.extends' => NULL,
        'entity.name.suffix' => NULL,
		'entity.name.singularize' => FALSE,
        'entity.filename.suffix' => NULL,
        // Repository
        'repository.folder' => NULL,
        'repository.namespace' => NULL,
        'repository.extends' => NULL,
        'repository.name.suffix' => NULL,
		'repository.name.singularize' => FALSE,
        'repository.filename.suffix' => NULL,
        // Mapper
        'mapper.folder' => NULL,
        'mapper.namespace' => NULL,
        'mapper.extends' => NULL,
        'mapper.name.suffix' => NULL,
		'mapper.name.singularize' => FALSE,
        'mapper.filename.suffix' => NULL,
        // Facade
        'facade.folder' => NULL,
        'facade.namespace' => NULL,
        'facade.extends' => NULL,
        'facade.name.suffix' => NULL,
		'facade.name.singularize' => FALSE,
        'facade.filename.suffix' => NULL,

		'nextras.orm.class.model' => 'Nextras\Orm\Model\Model'
    ];

    /** @var array */
    protected $config = [];

    /**
     * @param array $configuration
     */
    public function __construct(array $configuration)
    {
        // Validate config
        if ($extra = array_diff_key((array)$configuration, $this->defaults)) {
            $extra = implode(", ", array_keys($extra));
            throw new InvalidStateException("Unknown configuration option $extra.");
        }

        $this->config = array_merge($this->defaults, $configuration);
    }

    /**
     * MAGIC METHODS ***********************************************************
     */

    /**
     * @param string $name
     * @return mixed
     */
    function __get($name)
    {
        return $this->offsetGet($name);
    }

    /**
     * @param string $name
     * @param mixed $value
     */
    function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function get($name)
    {
        return $this->offsetGet($name);
    }

    /**
     * ARRAY ACCESS ************************************************************
     */

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return array_key_exists($offset, $this->config);
    }

    /**
     * @param mixed $offset
     * @return mixed
     * @throws InvalidStateException
     */
    public function offsetGet($offset)
    {
        if ($this->offsetExists($offset)) {
            return $this->config[$offset];
        }

        throw new InvalidStateException('Undefined offset: ' . $offset);
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->config[$offset] = $value;
    }

    /**
     * @param int $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->config[$offset]);
    }

}
