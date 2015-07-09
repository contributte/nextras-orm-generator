<?php

namespace Minetro\Normgen;

use Minetro\Normgen\Entity\Database;
use Minetro\Resolver\IMapperResolver;
use Nette\PhpGenerator\Helpers;
use Nette\PhpGenerator\PhpNamespace;

class MapperGenerator extends AbstractGenerator
{

    /** @var IMapperResolver */
    private $resolver;

    /**
     * @param Config $config
     * @param IMapperResolver $resolver
     */
    function __construct(Config $config, IMapperResolver $resolver)
    {
        parent::__construct($config);

        $this->resolver = $resolver;
    }

    /**
     * @param Database $database
     */
    public function generate(Database $database)
    {
        foreach ($database->getTables() as $table) {

            // Create namespace and inner class
            $namespace = new PhpNamespace($this->config->get('mapper.namespace'));
            $class = $namespace->addClass($this->resolver->resolveMapperName($table));

            // Detect extends class
            if (($extends = $this->config->get('mapper.extends')) !== NULL) {
                $namespace->addUse($extends);
                $class->setExtends($extends);
            }

            // Save file
            $this->generateFile($this->config->get('mapper.folder'), $this->resolver->resolveMapperFilename($table), (string)$namespace);
        }

        // Generate abstract base class
        if ($this->config->get('mapper.extends') !== NULL) {
            // Create abstract class
            $namespace = new PhpNamespace($this->config->get('mapper.namespace'));
            $class = $namespace->addClass(Helpers::extractShortName($this->config->get('mapper.extends')));
            $class->setAbstract(TRUE);

            // Add extends from ORM/Mapper
            $extends = $this->config->get('orm.class.mapper');
            $namespace->addUse($extends);
            $class->setExtends($extends);

            // Save file
            $this->generateFile($this->config->get('mapper.folder'), $this->resolver->resolveFilename(Helpers::extractShortName($this->config->get('mapper.extends'))), (string)$namespace);
        }
    }

}
