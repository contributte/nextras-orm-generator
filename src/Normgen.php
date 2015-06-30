<?php

namespace Minetro\Normgen;

use Minetro\Normgen\Analyser\Analyser;
use Minetro\Normgen\Entity\Database;
use Minetro\Normgen\Generator\Entity\ColumnDocumentor;
use Minetro\Normgen\Generator\Entity\ColumnMapper;
use Minetro\Resolver\Resolver;
use Nette\PhpGenerator\PhpNamespace;
use Nette\Utils\FileSystem;

class Normgen
{

    /** @var Config */
    private $config;

    /** @var Analyser */
    private $analyser;

    /** @var ColumnMapper */
    private $columnMapper;

    /** @var ColumnDocumentor */
    private $columnDocumentor;

    /**
     * @param Config $config
     * @param Analyser $analyser
     * @param Resolver $resolver
     */
    function __construct(Config $config, Analyser $analyser, Resolver $resolver)
    {
        $this->config = $config;
        $this->analyser = $analyser;
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
     * Generate ORM
     */
    public function generate()
    {
        $database = $this->analyser->analyse();

        if ($this->config->get('generate.entities')) {
            //$this->generateEntities($database);
        }
        if ($this->config->get('generate.repositories')) {
            //$this->generateRepositories($database);
        }
        if ($this->config->get('generate.mappers')) {
            //$this->generateMappers($database);
        }
        if ($this->config->get('generate.facades')) {
            //$this->generateFacades($database);
        }
    }

    /**
     * @param Database $database
     */
    public function generateEntities(Database $database)
    {
        foreach ($database->getTables() as $table) {

            $namespace = new PhpNamespace($this->config->get('entity.namespace'));
            $class = $namespace->addClass($this->resolver->resolveEntityName($table));

            if (($extends = $this->config->get('entity.extends')) !== NULL) {
                $namespace->addUse($extends);
                $class->setExtends($extends);
            }

            foreach ($table->getColumns() as $column) {

                if ($this->config->get('entity.exclude.primary')) {
                    if ($column->isPrimary()) continue;
                }

                $this->columnMapper->map($namespace, $class, $column);
                $class->addDocument($this->columnDocumentor->document($namespace, $class, $column));
            }

            $this->generateFile($this->resolver->resolveEntityFilename($table), (string)$namespace);
        }
    }

    /**
     * @param Database $database
     */
    public function generateRepositories(Database $database)
    {
        foreach ($database->getTables() as $table) {

            $namespace = new PhpNamespace($this->config->get('repository.namespace'));
            $class = $namespace->addClass($this->resolver->resolveRepositoryName($table));

            if (($extends = $this->config->get('entity.extends')) !== NULL) {
                $namespace->addUse($extends);
                $class->setExtends($extends);
            }

            $this->generateFile($this->resolver->resolveRepositoryFilename($table), (string)$namespace);
        }
    }

    /**
     * @param Database $database
     */
    public function generateMappers(Database $database)
    {
        foreach ($database->getTables() as $table) {

            $namespace = new PhpNamespace($this->config->get('mapper.namespace'));
            $class = $namespace->addClass($this->resolver->resolveRepositoryName($table));

            if (($extends = $this->config->get('entity.extends')) !== NULL) {
                $namespace->addUse($extends);
                $class->setExtends($extends);
            }

            $this->generateFile($this->resolver->resolveRepositoryFilename($table), (string)$namespace);
        }
    }

    /**
     * @param Database $database
     */
    public function generateFacades(Database $database)
    {
        foreach ($database->getTables() as $table) {

            $namespace = new PhpNamespace($this->config->get('facade.namespace'));
            $class = $namespace->addClass($this->resolver->resolveRepositoryName($table));

            if (($extends = $this->config->get('entity.extends')) !== NULL) {
                $namespace->addUse($extends);
                $class->setExtends($extends);
            }

            $this->generateFile($this->resolver->resolveRepositoryFilename($table), (string)$namespace);
        }
    }

    /**
     * Generate file
     *
     * @param string $filename
     * @param string $code
     */
    protected function generateFile($filename, $code)
    {
        FileSystem::write($this->config->get('output') . DIRECTORY_SEPARATOR . $filename, "<?php\n\n$code");
    }

}
