<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Config\Impl;

use Contributte\Nextras\Orm\Generator\Config\Config;

class SeparateConfig extends Config
{

	/** @var mixed[] */
	protected $defaults = [
		// Output folder
		'output' => null,
		// Generator
		'generator.generate.strategy' => Config::STRATEGY_SEPARATE,
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
		'orm.namespace' => null,
		'orm.singularize' => false,
		// Entity
		'entity.folder' => 'Entity',
		'entity.namespace' => 'App\Model\Entity',
		'entity.extends' => 'App\Model\Entity\AbstractEntity',
		'entity.name.suffix' => null,
		'entity.name.singularize' => false,
		'entity.filename.suffix' => null,
		'entity.generate.column.constant' => false,
		'entity.generate.relations' => true,
		'entity.column.constants.prefix' => 'COL_',
		// Repository
		'repository.folder' => 'Repository',
		'repository.namespace' => 'App\Model\Repository',
		'repository.extends' => 'App\Model\Repository\AbstractRepository',
		'repository.name.suffix' => 'Repository',
		'repository.name.singularize' => false,
		'repository.filename.suffix' => 'Repository',
		// Mapper
		'mapper.folder' => 'Mapper',
		'mapper.namespace' => 'App\Model\Mapper',
		'mapper.extends' => 'App\Model\Mapper\AbstractMapper',
		'mapper.name.suffix' => 'Mapper',
		'mapper.name.singularize' => false,
		'mapper.filename.suffix' => 'Mapper',
		// Facade
		'facade.folder' => 'Facade',
		'facade.namespace' => 'App\Model\Facade',
		'facade.extends' => 'App\Model\Facade\AbstractFacade',
		'facade.name.suffix' => 'Facade',
		'facade.name.singularize' => false,
		'facade.filename.suffix' => 'Facade',
		// model
		'model.folder' => null,
		'model.namespace' => 'App\Model',
		'model.name' => 'Orm',
		'model.filename' => 'Orm.php',

	];

}
