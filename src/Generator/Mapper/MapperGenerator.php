<?php

namespace Minetro\Normgen\Generator\Mapper;

use Minetro\Normgen\Config\Config;
use Minetro\Normgen\Entity\Database;
use Minetro\Normgen\Generator\AbstractGenerator;
use Minetro\Normgen\Resolver\IMapperResolver;
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
            $namespace = new PhpNamespace($this->resolver->resolveMapperNamespace($table));
            $class = $namespace->addClass($this->resolver->resolveMapperName($table));

            // Detect extends class
            if (($extends = $this->config->get('mapper.extends')) !== NULL) {
                $namespace->addUse($extends);
                $class->setExtends($extends);
            }

            // Save file
            $this->generateFile($this->resolver->resolveMapperFilename($table), (string)$namespace);
        }

        // Generate abstract base class
        if ($this->config->get('mapper.extends') !== NULL) {
            // Create abstract class
            $namespace = new PhpNamespace($this->config->get('mapper.namespace'));
            $class = $namespace->addClass(Helpers::extractShortName($this->config->get('mapper.extends')));
            $class->setAbstract(TRUE);

            // Add extends from ORM/Mapper
            $extends = $this->config->get('nextras.orm.class.mapper');
            $namespace->addUse($extends);
            $class->setExtends($extends);

            // Save file
            $this->generateFile($this->resolver->resolveFilename(Helpers::extractShortName($this->config->get('mapper.extends')), $this->config->get('mapper.folder')), (string)$namespace);
        }
    }

}
