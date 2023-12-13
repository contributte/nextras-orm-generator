<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Generator\Mapper;

use Contributte\Nextras\Orm\Generator\Config\Config;
use Contributte\Nextras\Orm\Generator\Entity\Database;
use Contributte\Nextras\Orm\Generator\Generator\AbstractGenerator;
use Contributte\Nextras\Orm\Generator\Resolver\IMapperResolver;
use Nette\PhpGenerator\Helpers;
use Nette\PhpGenerator\PhpNamespace;

class MapperGenerator extends AbstractGenerator
{

	private IMapperResolver $resolver;

	public function __construct(Config $config, IMapperResolver $resolver)
	{
		parent::__construct($config);

		$this->resolver = $resolver;
	}

	public function generate(Database $database): void
	{
		foreach ($database->getTables() as $table) {
			// Create namespace and inner class
			$namespace = new PhpNamespace($this->resolver->resolveMapperNamespace($table));
			$class = $namespace->addClass($this->resolver->resolveMapperName($table));

			// Detect extends class
			if (($extends = $this->config->getString('mapper.extends')) !== '') {
				$namespace->addUse($extends);
				$class->setExtends($extends);
			}

			$class->addMethod('getTableName')
				->setBody('return \'' . $table->getName() . '\';')
				->setReturnType('string')
				->setVisibility('public');

			// Save file
			$this->generateFile($this->resolver->resolveMapperFilename($table), (string) $namespace);
		}

		// Generate abstract base class
		if ($this->config->getString('mapper.extends') !== '') {
			// Create abstract class
			$namespace = new PhpNamespace($this->config->getString('mapper.namespace'));
			$class = $namespace->addClass(Helpers::extractShortName($this->config->getString('mapper.extends')));
			$class->setAbstract(true);

			// Add extends from ORM/Mapper
			$extends = $this->config->getString('nextras.orm.class.mapper');
			$namespace->addUse($extends);
			$class->setExtends($extends);

			// Save file
			$this->generateFile($this->resolver->resolveFilename(Helpers::extractShortName($this->config->getString('mapper.extends')), $this->config->getString('mapper.folder')), (string) $namespace);
		}
	}

}
