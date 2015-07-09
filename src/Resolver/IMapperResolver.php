<?php

namespace Minetro\Resolver;

use Minetro\Normgen\Entity\Table;

interface IMapperResolver extends IFilenameResolver
{

    /**
     * @param Table $table
     * @return string
     */
    function resolveRepositoryFilename(Table $table);

    /**
     * @param Table $table
     * @return string
     */
    function resolveMapperName(Table $table);
}