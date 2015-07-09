<?php

namespace Minetro\Normgen;

use Minetro\Normgen\Analyser\Analyser;
use Minetro\Resolver\SimpleResolver;

class Normgen
{

    /** @var Config */
    private $config;

    /** @var Analyser */
    private $analyser;

    /** @var EntityGenerator */
    private $entityGenerator;

    /** @var RepositoryGenerator */
    private $repositoryGenerator;

    /** @var MapperGenerator */
    private $mapperGenerator;

    /** @var FacadeGenerator */
    private $facadeGenerator;

    /**
     * @param Config $config
     * @param Analyser $analyser
     */
    function __construct(Config $config, Analyser $analyser)
    {
        $this->config = $config;
        $this->analyser = $analyser;

        $resolver = new SimpleResolver($config);

        $this->entityGenerator = new EntityGenerator($config, $resolver);
        $this->repositoryGenerator = new RepositoryGenerator($config, $resolver);
        $this->mapperGenerator = new MapperGenerator($config, $resolver);
        $this->facadeGenerator = new FacadeGenerator($config, $resolver);
    }

    /**
     * Generate ORM
     */
    public function generate()
    {
        $database = $this->analyser->analyse();

        if ($this->config->get('generate.entities')) {
            $this->entityGenerator->generate($database);
        }
        if ($this->config->get('generate.repositories')) {
            $this->repositoryGenerator->generate($database);
        }
        if ($this->config->get('generate.mappers')) {
            $this->mapperGenerator->generate($database);
        }
        if ($this->config->get('generate.facades')) {
            $this->facadeGenerator->generate($database);
        }
    }

}
