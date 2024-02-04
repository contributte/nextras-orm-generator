<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Generator\Repository;

use Contributte\Nextras\Orm\Generator\Config\Config;
use Contributte\Nextras\Orm\Generator\Entity\Database;
use Contributte\Nextras\Orm\Generator\Generator\AbstractGenerator;
use Contributte\Nextras\Orm\Generator\Resolver\IEntityResolver;
use Contributte\Nextras\Orm\Generator\Resolver\IRepositoryResolver;
use Nette\PhpGenerator\Helpers;
use Nette\PhpGenerator\PhpNamespace;

class RepositoryGenerator extends AbstractGenerator
{

	private IRepositoryResolver $resolver;

	private IEntityResolver $entityResolver;

	public function __construct(Config $config, IRepositoryResolver $resolver, IEntityResolver $entityResolver)
	{
		parent::__construct($config);

		$this->resolver = $resolver;
		$this->entityResolver = $entityResolver;
	}

	public function generate(Database $database): void
	{
		foreach ($database->getTables() as $table) {
			// Create namespace and inner class
			$namespace = new PhpNamespace($this->resolver->resolveRepositoryNamespace($table));
			$class = $namespace->addClass($this->resolver->resolveRepositoryName($table));

			// Detect extends class
			if (($extends = $this->config->getString('repository.extends')) !== '') {
				$namespace->addUse($extends);
				$class->setExtends($extends);
			}

			$namespace->addUse($this->entityResolver->resolveEntityNamespace($table) . '\\' . $this->entityResolver->resolveEntityName($table));
			$entityName = $this->entityResolver->resolveEntityName($table);
			$class->addMethod('getEntityClassNames')
				->setReturnType('array')
				->setVisibility('public')
				->setStatic()
				->addBody('return [' . $entityName . '::class];');

			// Save file
			$this->generateFile($this->resolver->resolveRepositoryFilename($table), (string) $namespace);
		}

		// Generate abstract base class
		if ($this->config->getString('repository.extends') !== '') {
			// Create abstract class
			$namespace = new PhpNamespace($this->config->getString('repository.namespace'));
			$class = $namespace->addClass(Helpers::extractShortName($this->config->getString('repository.extends')));
			$class->setAbstract(true);

			// Add extends from ORM/Repository
			$extends = $this->config->getString('nextras.orm.class.repository');
			$namespace->addUse($extends);
			$class->setExtends($extends);

			// Save file
			$this->generateFile($this->resolver->resolveFilename(Helpers::extractShortName($this->config->getString('repository.extends')), $this->config->getStringNull('repository.folder')), (string) $namespace);
		}
	}

}
