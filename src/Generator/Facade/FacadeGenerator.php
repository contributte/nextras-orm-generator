<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Generator\Facade;

use Contributte\Nextras\Orm\Generator\Config\Config;
use Contributte\Nextras\Orm\Generator\Entity\Database;
use Contributte\Nextras\Orm\Generator\Generator\AbstractGenerator;
use Contributte\Nextras\Orm\Generator\Resolver\IFacadeResolver;
use Nette\PhpGenerator\Helpers;
use Nette\PhpGenerator\PhpNamespace;

class FacadeGenerator extends AbstractGenerator
{

	/** @var IFacadeResolver */
	private $resolver;

	public function __construct(Config $config, IFacadeResolver $resolver)
	{
		parent::__construct($config);

		$this->resolver = $resolver;
	}

	public function generate(Database $database): void
	{
		foreach ($database->getTables() as $table) {
			// Create namespace and inner class
			$namespace = new PhpNamespace($this->resolver->resolveFacadeNamespace($table));
			$class = $namespace->addClass($this->resolver->resolveFacadeName($table));

			// Detect extends class
			if (($extends = $this->config->get('facade.extends')) !== null) {
				$namespace->addUse($extends);
				$class->setExtends($extends);
			}

			// Save file
			$this->generateFile($this->resolver->resolveFacadeFilename($table), (string) $namespace);
		}

		// Generate abstract base class
		if ($this->config->get('facade.extends') !== null) {
			// Create abstract class
			$namespace = new PhpNamespace($this->config->get('facade.namespace'));
			$class = $namespace->addClass(Helpers::extractShortName($this->config->get('facade.extends')));
			$class->setAbstract(true);

			// Save file
			$this->generateFile($this->resolver->resolveFilename(Helpers::extractShortName($this->config->get('facade.extends')), $this->config->get('facade.folder')), (string) $namespace);
		}
	}

}
