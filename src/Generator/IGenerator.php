<?php

namespace Contributte\Nextras\Orm\Generator\Generator;

use Contributte\Nextras\Orm\Generator\Entity\Database;

interface IGenerator
{

    /**
     * @param Database $database
     * @return void
     */
    function generate(Database $database);

}
