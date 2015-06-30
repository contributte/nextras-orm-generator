<?php

namespace Minetro\Resolver;

use Minetro\Normgen\Config;
use Minetro\Normgen\Entity\Table;

class SimpleResolver implements Resolver
{

    /** @var Config */
    private $config;

    /**
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveEntityName(Table $table)
    {
        return ucfirst($table->getName()) . $this->config->get('entity.name.suffix');
    }

    /**
     * @param Table $table
     * @return string
     */
    public function resolveEntityFilename(Table $table)
    {
        return ucfirst($table->getName()) . $this->config->get('entity.filename.suffix') . '.php';
    }

}
