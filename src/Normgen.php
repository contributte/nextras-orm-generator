<?php

namespace Minetro\Normgen;

use Minetro\Normgen\Analyser\IAnalyser;
use Minetro\Normgen\Config\Config;
use Minetro\Normgen\Generator\IGenerator;

class Normgen
{

    /** @var Config */
    private $config;

    /** @var IAnalyser */
    private $analyser;

    /** @var IGenerator */
    private $entityGenerator;

    /** @var IGenerator */
    private $repositoryGenerator;

    /** @var IGenerator */
    private $mapperGenerator;

    /** @var IGenerator */
    private $facadeGenerator;

    /**
     * @param Config $config
     * @param IAnalyser $analyser
     */
    function __construct(Config $config, IAnalyser $analyser)
    {
        $this->config = $config;
        $this->analyser = $analyser;
    }

    /**
     * GETTERS/SETTERS *********************************************************
     */

    /**
     * @return IGenerator
     */
    public function getEntityGenerator()
    {
        return $this->entityGenerator;
    }

    /**
     * @param IGenerator $generator
     */
    public function setEntityGenerator(IGenerator $generator)
    {
        $this->entityGenerator = $generator;
    }

    /**
     * @return IGenerator
     */
    public function getRepositoryGenerator()
    {
        return $this->repositoryGenerator;
    }

    /**
     * @param IGenerator $generator
     */
    public function setRepositoryGenerator(IGenerator $generator)
    {
        $this->repositoryGenerator = $generator;
    }

    /**
     * @return IGenerator
     */
    public function getMapperGenerator()
    {
        return $this->mapperGenerator;
    }

    /**
     * @param IGenerator $generator
     */
    public function setMapperGenerator(IGenerator $generator)
    {
        $this->mapperGenerator = $generator;
    }

    /**
     * @return IGenerator
     */
    public function getFacadeGenerator()
    {
        return $this->facadeGenerator;
    }

    /**
     * @param IGenerator $generator
     */
    public function setFacadeGenerator(IGenerator $generator)
    {
        $this->facadeGenerator = $generator;
    }

    /**
     * Generate ORM
     */
    public function generate()
    {
        $database = $this->analyser->analyse();

        if ($this->config->get('generator.generate.entities')) {
            $this->entityGenerator->generate($database);
        }
        if ($this->config->get('generator.generate.repositories')) {
            $this->repositoryGenerator->generate($database);
        }
        if ($this->config->get('generator.generate.mappers')) {
            $this->mapperGenerator->generate($database);
        }
        if ($this->config->get('generator.generate.facades')) {
            $this->facadeGenerator->generate($database);
        }
    }

}
