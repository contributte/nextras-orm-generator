<?php

namespace Minetro\Normgen\Resolver;

use Minetro\Normgen\Entity\Table;

interface IRepositoryResolver extends IFilenameResolver
{

    /**
     * @param Table $table
     * @return string
     */
    function resolveRepositoryName(Table $table);

    /**
     * @param Table $table
     * @return string
     */
    function resolveRepositoryNamespace(Table $table);

    /**
     * @param Table $table
     * @return string
     */
    function resolveRepositoryFilename(Table $table);

}