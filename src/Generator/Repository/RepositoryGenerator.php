<?php

namespace Minetro\Normgen\Generator\Repository;

use Minetro\Normgen\Config\Config;
use Minetro\Normgen\Entity\Database;
use Minetro\Normgen\Generator\AbstractGenerator;
use Minetro\Normgen\Resolver\IRepositoryResolver;
use Nette\PhpGenerator\Helpers;
use Nette\PhpGenerator\PhpNamespace;
use Minetro\Normgen\Resolver\IEntityResolver;

class RepositoryGenerator extends AbstractGenerator
{

    /** @var IRepositoryResolver */
    private $resolver;
    
    /** @var IEntityResolver */
    private $entityResolver;

    /**
     * @param Config $config
     * @param IRepositoryResolver $resolver
     * @param IEntityResolver $entityResolver
     */
    function __construct(Config $config, IRepositoryResolver $resolver, IEntityResolver $entityResolver)
    {
        parent::__construct($config);

        $this->resolver = $resolver;
        $this->entityResolver = $entityResolver;
    }

    /**
     * @param Database $database
     */
    public function generate(Database $database)
    {
        foreach ($database->getTables() as $table) {
            // Create namespace and inner class
            $namespace = new PhpNamespace($this->resolver->resolveRepositoryNamespace($table));
            $class = $namespace->addClass($this->resolver->resolveRepositoryName($table));

            // Detect extends class
            if (($extends = $this->config->get('repository.extends')) !== NULL) {
                $namespace->addUse($extends);
                $class->setExtends($extends);
            }

            $entityName = $this->entityResolver->resolveEntityName($table);
            $class->addMethod("getEntityClassNames")
				->addDocument("@return array")
				->setVisibility('public')
				->setStatic(true)
				->addBody("return [$entityName::class];");
            
            // Save file
            $this->generateFile($this->resolver->resolveRepositoryFilename($table), (string)$namespace);
        }

        // Generate abstract base class
        if ($this->config->get('repository.extends') !== NULL) {
            // Create abstract class
            $namespace = new PhpNamespace($this->config->get('repository.namespace'));
            $class = $namespace->addClass(Helpers::extractShortName($this->config->get('repository.extends')));
            $class->setAbstract(TRUE);

            // Add extends from ORM/Repository
            $extends = $this->config->get('nextras.orm.class.repository');
            $namespace->addUse($extends);
            $class->setExtends($extends);

            // Save file
            $this->generateFile($this->resolver->resolveFilename(Helpers::extractShortName($this->config->get('repository.extends')), $this->config->get('repository.folder')), (string)$namespace);
        }
    }

}
