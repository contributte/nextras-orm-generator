<?php

namespace Minetro\Normgen\Analyser;

use Minetro\Normgen\Entity\Database;

interface Analyser
{

    /**
     * @return Database
     */
    function analyse();

}
