<?php

namespace Minetro\Normgen;

use Minetro\Normgen\Entity\Database;
use Minetro\Normgen\Generator\Entity\ColumnDocumentor;
use Minetro\Normgen\Generator\Entity\ColumnMapper;
use Minetro\Resolver\IEntityResolver;
use Nette\PhpGenerator\Helpers;
use Nette\PhpGenerator\PhpNamespace;

class EntityGenerator extends AbstractGenerator
{

    /** @var IEntityResolver */
    private $resolver;

    /** @var ColumnMapper */
    private $columnMapper;

    /** @var ColumnDocumentor */
    private $columnDocumentor;

    /**
     * @param Config $config
     * @param IEntityResolver $resolver
     */
    function __construct(Config $config, IEntityResolver $resolver)
    {
        parent::__construct($config);

        $this->resolver = $resolver;
        $this->columnMapper = new ColumnMapper();
        $this->columnDocumentor = new ColumnDocumentor();
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
            $namespace = new PhpNamespace($this->config->get('entity.namespace'));
            $class = $namespace->addClass($this->resolver->resolveEntityName($table));

            // Detect extends class
            if (($extends = $this->config->get('entity.extends')) === NULL) {
                $extends = $this->config->get('orm.class.entity');
            }

            // Add namespace and extends class
            $namespace->addUse($extends);
            $class->setExtends($extends);

            // Add table columns
            foreach ($table->getColumns() as $column) {

                if ($this->config->get('entity.exclude.primary')) {
                    if ($column->isPrimary()) continue;
                }

                // Map columns
                $this->columnMapper->doMapping($namespace, $class, $column);

                // Resolve advanced phpDoc
                $this->columnDocumentor->doPrepare($column, $this->resolver);

                // Add phpDoc
                $class->addDocument($this->columnDocumentor->doDocument($column));
            }

            // Save file
            $this->generateFile($this->config->get('entity.folder'), $this->resolver->resolveEntityFilename($table), (string)$namespace);
        }

        // Generate abstract base class
        if ($this->config->get('entity.extends') !== NULL) {
            // Create abstract class
            $namespace = new PhpNamespace($this->config->get('entity.namespace'));
            $class = $namespace->addClass(Helpers::extractShortName($this->config->get('entity.extends')));
            $class->setAbstract(TRUE);

            // Add extends from ORM/Entity
            $extends = $this->config->get('orm.class.entity');
            $namespace->addUse($extends);
            $class->setExtends($extends);

            // Save file
            $this->generateFile($this->config->get('entity.folder'), $this->resolver->resolveFilename(Helpers::extractShortName($this->config->get('entity.extends'))), (string)$namespace);
        }
    }

}
