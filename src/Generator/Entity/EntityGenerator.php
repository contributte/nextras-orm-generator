<?php declare(strict_types = 1);

namespace Contributte\Nextras\Orm\Generator\Generator\Entity;

use Contributte\Nextras\Orm\Generator\Config\Config;
use Contributte\Nextras\Orm\Generator\Entity\Database;
use Contributte\Nextras\Orm\Generator\Generator\AbstractGenerator;
use Contributte\Nextras\Orm\Generator\Generator\Entity\Decorator\ColumnConstantGenerator;
use Contributte\Nextras\Orm\Generator\Generator\Entity\Decorator\ColumnDocumentor;
use Contributte\Nextras\Orm\Generator\Generator\Entity\Decorator\ColumnMapper;
use Contributte\Nextras\Orm\Generator\Generator\Entity\Decorator\IDecorator;
use Contributte\Nextras\Orm\Generator\Resolver\IEntityResolver;
use Nette\PhpGenerator\Helpers;
use Nette\PhpGenerator\PhpNamespace;

class EntityGenerator extends AbstractGenerator
{

	/** @var IEntityResolver */
	private $resolver;

	/** @var IDecorator[] */
	private $decorators = [];

	public function __construct(Config $config, IEntityResolver $resolver)
	{
		parent::__construct($config);

		$this->resolver = $resolver;

		$this->decorators[] = new ColumnMapper();
		$this->decorators[] = new ColumnDocumentor($resolver, $config->get('entity.generate.relations'));
		$this->decorators[] = new ColumnConstantGenerator($config);
	}

	public function generate(Database $database): void
	{
		foreach ($database->getTables() as $table) {
			// Create namespace and inner class
			$namespace = new PhpNamespace($this->resolver->resolveEntityNamespace($table));
			$class = $namespace->addClass($this->resolver->resolveEntityName($table));

			// Detect extends class
			if (($extends = $this->config->get('entity.extends')) === null) {
				$extends = $this->config->get('nextras.orm.class.entity');
			}

			// Add namespace and extends class
			$namespace->addUse($extends);
			$class->setExtends($extends);

			// Add table columns
			foreach ($table->getColumns() as $column) {
				if ($this->config->get('generator.entity.exclude.primary')) {
					if ($column->isPrimary()) continue;
				}

				foreach ($this->decorators as $decorator) {
					$decorator->doDecorate($column, $class, $namespace);
				}
			}

			// Save file
			$this->generateFile($this->resolver->resolveEntityFilename($table), (string) $namespace);
		}

		// Generate abstract base class
		if ($this->config->get('entity.extends') !== null) {
			// Create abstract class
			$namespace = new PhpNamespace($this->config->get('entity.namespace'));
			$class = $namespace->addClass(Helpers::extractShortName($this->config->get('entity.extends')));
			$class->setAbstract();

			// Add extends from ORM/Entity
			$extends = $this->config->get('nextras.orm.class.entity');
			$namespace->addUse($extends);
			$class->setExtends($extends);

			// Save file
			$this->generateFile($this->resolver->resolveFilename(Helpers::extractShortName($this->config->get('entity.extends')), $this->config->get('entity.folder')), (string) $namespace);
		}
	}

}
