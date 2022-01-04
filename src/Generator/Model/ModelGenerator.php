<?php declare (strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Generator\Model;

use Contributte\Nextras\Orm\Generator\Config\Config;
use Contributte\Nextras\Orm\Generator\Entity\Database;
use Contributte\Nextras\Orm\Generator\Entity\PhpDoc;
use Contributte\Nextras\Orm\Generator\Generator\AbstractGenerator;
use Contributte\Nextras\Orm\Generator\Resolver\IEntityResolver;
use Contributte\Nextras\Orm\Generator\Resolver\IModelResolver;
use Contributte\Nextras\Orm\Generator\Resolver\IRepositoryResolver;
use Contributte\Nextras\Orm\Generator\Utils\Helpers;
use Nette\PhpGenerator\PhpNamespace;

class ModelGenerator extends AbstractGenerator
{

	/** @var IModelResolver */
	private $modelResolver;

	/** @var IRepositoryResolver */
	private $repositoryResolver;

	/** @var IEntityResolver */
	private $entityResolver;

	public function __construct(Config $config, IModelResolver $resolver, IRepositoryResolver $repositoryResolver, IEntityResolver $entityResolver)
	{
		parent::__construct($config);
		$this->modelResolver = $resolver;
		$this->repositoryResolver = $repositoryResolver;
		$this->entityResolver = $entityResolver;
	}

	public function generate(Database $database): void
	{
		$namespace = new PhpNamespace($this->modelResolver->resolveModelNamespace());
		$nextrasModelClass = $this->config->get('nextras.orm.class.model');
		$namespace->addUse($nextrasModelClass);
		$class = $namespace->addClass($this->modelResolver->resolveModelName());
		$class->setExtends($nextrasModelClass);
		foreach ($database->getTables() as $table) {
			$namespace->addUse($this->repositoryResolver->resolveRepositoryNamespace($table) . Helpers::NS . $this->repositoryResolver->resolveRepositoryName($table));
			$doc = new PhpDoc();
			$doc->setAnnotation('@property-read');
			$doc->setType($this->repositoryResolver->resolveRepositoryName($table));
			$doc->setVariable(lcfirst($this->entityResolver->resolveEntityName($table)));
			$class->addComment((string) $doc);
		}

		$this->generateFile($this->modelResolver->resolveModelFilename(), (string) $namespace);
	}

}
