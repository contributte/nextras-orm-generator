<?php

namespace Minetro\Resolver;

use Minetro\Normgen\Entity\Table;

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
    function resolveFacadeFilename(Table $table);
}