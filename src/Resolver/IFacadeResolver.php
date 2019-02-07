<?php

namespace Contributte\Nextras\Orm\Generator\Resolver;

use Contributte\Nextras\Orm\Generator\Entity\Table;

interface IFacadeResolver extends IFilenameResolver
{

    /**
     * @param Table $table
     * @return string
     */
    function resolveFacadeName(Table $table);

    /**
     * @param Table $table
     * @return string
     */
    function resolveFacadeNamespace(Table $table);

    /**
     * @param Table $table
     * @return string
     */
    function resolveFacadeFilename(Table $table);
}