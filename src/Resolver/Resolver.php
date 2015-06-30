<?php

namespace Minetro\Resolver;

use Minetro\Normgen\Entity\Table;

interface Resolver
{

    /**
     * @param Table $table
     * @return string
     */
    function resolveEntityName(Table $table);

    /**
     * @param Table $table
     * @return string
     */
    function resolveEntityFilename(Table $table);

}