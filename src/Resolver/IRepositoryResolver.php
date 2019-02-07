<?php

namespace Contributte\Nextras\Orm\Generator\Resolver;

use Contributte\Nextras\Orm\Generator\Entity\Table;

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