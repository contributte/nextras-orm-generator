<?php

namespace Minetro\Normgen\Generator\Entity;

use Minetro\Normgen\Config\Config;
use Minetro\Normgen\Entity\Database;
use Minetro\Normgen\Generator\AbstractGenerator;
use Minetro\Normgen\Generator\Entity\Decorator\ColumnDocumentor;
use Minetro\Normgen\Generator\Entity\Decorator\ColumnMapper;
use Minetro\Normgen\Generator\Entity\Decorator\IDecorator;
use Minetro\Normgen\Resolver\IEntityResolver;
use Nette\PhpGenerator\Helpers;
use Nette\PhpGenerator\PhpNamespace;

class EntityGenerator extends AbstractGenerator
{

    /** @var IEntityResolver */
    private $resolver;

    /** @var IDecorator[] */
    private $decorators = [];

    /**
     * @param Config $config
     * @param IEntityResolver $resolver
     */
    function __construct(Config $config, IEntityResolver $resolver)
    {
        parent::__construct($config);

        $this->resolver = $resolver;

        $this->decorators[] = new ColumnMapper();
        $this->decorators[] = new ColumnDocumentor($resolver);
    }

    /**
     * @param ColumnMapper $columnMapper
     */
    public function setColumnMapper($columnMapper)
    {
        $this->columnMapper = $columnMapper;
    }

    /**
     * @param ColumnDocumentor $columnDocumentor
     */
    public function setColumnDocumentor($columnDocumentor)
    {
        $this->columnDocumentor = $columnDocumentor;
    }

    /**
     * @param Database $database
     */
    public function generate(Database $database)
    {
        foreach ($database->getTables() as $table) {
            // Create namespace and inner class
            $namespace = new PhpNamespace($this->resolver->resolveEntityNamespace($table));
            $class = $namespace->addClass($this->resolver->resolveEntityName($table));

            // Detect extends class
            if (($extends = $this->config->get('entity.extends')) === NULL) {
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
            $this->generateFile($this->resolver->resolveEntityFilename($table), (string)$namespace);
        }

        // Generate abstract base class
        if ($this->config->get('entity.extends') !== NULL) {
            // Create abstract class
            $namespace = new PhpNamespace($this->config->get('entity.namespace'));
            $class = $namespace->addClass(Helpers::extractShortName($this->config->get('entity.extends')));
            $class->setAbstract(TRUE);

            // Add extends from ORM/Entity
            $extends = $this->config->get('nextras.orm.class.entity');
            $namespace->addUse($extends);
            $class->setExtends($extends);

            // Save file
            $this->generateFile($this->resolver->resolveFilename(Helpers::extractShortName($this->config->get('entity.extends')), $this->config->get('entity.folder')), (string)$namespace);
        }
    }

}
