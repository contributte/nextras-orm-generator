<?php

namespace Minetro\Normgen;

use Nette\InvalidStateException;

class Config
{

    /** Strategy types */
    const STRATEGY_TOGETHER = 1;
    const STRATEGY_SEPARATE = 2;

    /** @var array */
    protected $defaults = [
        // Output folder
        'output' => NULL,
        // 1 => Entity + Repository + Mapper + Facade => same folder
        // 2 => Entities, Repositories, Mappers, Facades => same folder for each group
        'generate.strategy' => self::STRATEGY_SEPARATE,
        // Generator
        'generate.entities' => TRUE,
        'generate.repositories' => TRUE,
        'generate.mappers' => TRUE,
        'generate.facades' => TRUE,
        // ORM
        'orm.class.entity' => 'Nextras\Orm\Entity\Entity',
        'orm.class.repository' => 'Nextras\Orm\Repository\Repository',
        'orm.class.mapper' => 'Nextras\Orm\Mapper\Mapper',
        // Entity
        'entity.folder' => 'Entity',
        'entity.namespace' => 'App\Model\Entity',
        'entity.extends' => 'App\Model\Entity\AbstractEntity',
        'entity.exclude.primary' => TRUE,
        'entity.name.suffix' => NULL,
        'entity.filename.suffix' => NULL,
        // Repository
        'repository.folder' => 'Repository',
        'repository.namespace' => 'App\Model\Repository',
        'repository.extends' => 'App\Model\Repository\AbstractRepository',
        'repository.name.suffix' => NULL,
        'repository.filename.suffix' => NULL,
        // Mapper
        'mapper.folder' => 'Mapper',
        'mapper.namespace' => 'App\Model\Mapper',
        'mapper.extends' => 'App\Model\Mapper\AbstractMapper',
        'mapper.name.suffix' => NULL,
        'mapper.filename.suffix' => NULL,
        // Facade
        'facade.folder' => 'Facade',
        'facade.namespace' => 'App\Model\Facade',
        'facade.extends' => 'App\Model\Facade\AbstractFacade',
        'facade.name.suffix' => NULL,
        'facade.filename.suffix' => NULL,
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
