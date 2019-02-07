<?php

namespace Minetro\Normgen\Config\Impl;

use Minetro\Normgen\Config\Config;

class SeparateConfig extends Config
{

    /** @var array */
    protected $defaults = [
        // Output folder
        'output' => NULL,
        // Generator
        'generator.generate.strategy' => Config::STRATEGY_SEPARATE,
        'generator.generate.entities' => TRUE,
        'generator.generate.repositories' => TRUE,
        'generator.generate.mappers' => TRUE,
        'generator.generate.facades' => TRUE,
        'generator.entity.exclude.primary' => TRUE,
        // NextrasORM
        'nextras.orm.class.entity' => 'Nextras\Orm\Entity\Entity',
        'nextras.orm.class.repository' => 'Nextras\Orm\Repository\Repository',
        'nextras.orm.class.mapper' => 'Nextras\Orm\Mapper\Mapper',
        // ORM
        'orm.namespace' => NULL,
		'orm.singularize' => FALSE,
        // Entity
        'entity.folder' => 'Entity',
        'entity.namespace' => 'App\Model\Entity',
        'entity.extends' => 'App\Model\Entity\AbstractEntity',
        'entity.name.suffix' => NULL,
		'entity.name.singularize' => FALSE,
        'entity.filename.suffix' => NULL,
        // Repository
        'repository.folder' => 'Repository',
        'repository.namespace' => 'App\Model\Repository',
        'repository.extends' => 'App\Model\Repository\AbstractRepository',
        'repository.name.suffix' => 'Repository',
		'repository.name.singularize' => FALSE,
        'repository.filename.suffix' => 'Repository',
        // Mapper
        'mapper.folder' => 'Mapper',
        'mapper.namespace' => 'App\Model\Mapper',
        'mapper.extends' => 'App\Model\Mapper\AbstractMapper',
        'mapper.name.suffix' => 'Mapper',
		'mapper.name.singularize' => FALSE,
        'mapper.filename.suffix' => 'Mapper',
        // Facade
        'facade.folder' => 'Facade',
        'facade.namespace' => 'App\Model\Facade',
        'facade.extends' => 'App\Model\Facade\AbstractFacade',
        'facade.name.suffix' => 'Facade',
		'facade.name.singularize' => FALSE,
        'facade.filename.suffix' => 'Facade',
    ];

}
