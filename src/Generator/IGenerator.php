<?php

namespace Minetro\Normgen\Generator;

use Minetro\Normgen\Entity\Database;

interface IGenerator
{

    /**
     * @param Database $database
     * @return void
     */
    function generate(Database $database);

}
