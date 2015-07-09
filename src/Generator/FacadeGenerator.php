<?php

namespace Minetro\Normgen;

use Minetro\Normgen\Entity\Database;
use Minetro\Resolver\IFacadeResolver;
use Nette\PhpGenerator\Helpers;
use Nette\PhpGenerator\PhpNamespace;

class FacadeGenerator extends AbstractGenerator
{

    /** @var IFacadeResolver */
    private $resolver;

    /**
     * @param Config $config
     * @param IFacadeResolver $resolver
     */
    function __construct(Config $config, IFacadeResolver $resolver)
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
            $namespace = new PhpNamespace($this->config->get('facade.namespace'));
            $class = $namespace->addClass($this->resolver->resolveFacadeName($table));

            // Detect extends class
            if (($extends = $this->config->get('facade.extends')) !== NULL) {
                $namespace->addUse($extends);
                $class->setExtends($extends);
            }

            // Save file
            $this->generateFile($this->config->get('facade.folder'), $this->resolver->resolveFacadeFilename($table), (string)$namespace);
        }

        // Generate abstract base class
        if ($this->config->get('facade.extends') !== NULL) {
            // Create abstract class
            $namespace = new PhpNamespace($this->config->get('facade.namespace'));
            $class = $namespace->addClass(Helpers::extractShortName($this->config->get('facade.extends')));
            $class->setAbstract(TRUE);

            // Save file
            $this->generateFile($this->config->get('facade.folder'), $this->resolver->resolveFilename(Helpers::extractShortName($this->config->get('facade.extends'))), (string)$namespace);
        }
    }

}
