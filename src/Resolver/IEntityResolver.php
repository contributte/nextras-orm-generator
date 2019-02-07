<?php

namespace Contributte\Nextras\Orm\Generator\Resolver;

use Contributte\Nextras\Orm\Generator\Entity\Table;

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
    function resolveEntityNamespace(Table $table);

    /**
     * @param Table $table
     * @return string
     */
    function resolveEntityFilename(Table $table);
}