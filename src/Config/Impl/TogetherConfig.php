<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Config\Impl;

use Contributte\Nextras\Orm\Generator\Config\Config;

class TogetherConfig extends Config
{

	/** @var mixed[] */
	protected $defaults = [
		// Output folder
		'output' => null,
		// Generator
		'generator.generate.strategy' => Config::STRATEGY_TOGETHER,
		'generator.generate.entities' => true,
		'generator.generate.repositories' => true,
		'generator.generate.mappers' => true,
		'generator.generate.facades' => true,
		'generator.generate.model' => true,
		'generator.entity.exclude.primary' => true,
		// NextrasORM
		'nextras.orm.class.entity' => 'Nextras\Orm\Entity\Entity',
		'nextras.orm.class.repository' => 'Nextras\Orm\Repository\Repository',
		'nextras.orm.class.mapper' => 'Nextras\Orm\Mapper\Mapper',
		'nextras.orm.class.model' => 'Nextras\Orm\Model\Model',
		// ORM
		'orm.namespace' => 'App\Model',
		'orm.singularize' => false,
		// Entity
		'entity.folder' => null,
		'entity.namespace' => 'App\Model',
		'entity.extends' => 'App\Model\Entity\AbstractEntity',
		'entity.name.suffix' => null,
		'entity.name.singularize' => false,
		'entity.filename.suffix' => null,
		'entity.generate.column.constant' => false,
		'entity.generate.relations' => true,
		'entity.column.constants.prefix' => 'COL_',
		// Repository
		'repository.folder' => null,
		'repository.namespace' => 'App\Model',
		'repository.extends' => 'App\Model\AbstractRepository',
		'repository.name.suffix' => 'Repository',
		'repository.name.singularize' => false,
		'repository.filename.suffix' => 'Repository',
		// Mapper
		'mapper.folder' => null,
		'mapper.namespace' => 'App\Model',
		'mapper.extends' => 'App\Model\AbstractMapper',
		'mapper.name.suffix' => 'Mapper',
		'mapper.name.singularize' => false,
		'mapper.filename.suffix' => 'Mapper',
		// Facade
		'facade.folder' => null,
		'facade.namespace' => 'App\Model',
		'facade.extends' => 'App\Model\AbstractFacade',
		'facade.name.suffix' => 'Facade',
		'facade.name.singularize' => false,
		'facade.filename.suffix' => 'Facade',
		// model
		'model.folder' => null,
		'model.namespace' => 'App\Model',
		'model.extends' => null,
		'model.name' => 'Orm',
		'model.filename' => 'Orm.php',
	];

}
