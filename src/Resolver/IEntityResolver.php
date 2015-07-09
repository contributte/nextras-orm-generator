<?php

namespace Minetro\Resolver;

use Minetro\Normgen\Entity\Table;

interface IEntityResolver extends IFilenameResolver
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