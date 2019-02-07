<?php

namespace Contributte\Nextras\Orm\Generator\Utils;

class DocBuilder
{

    /** @var array */
    private $builder = [];

    /**
     * @param string $str
     * @return self
     */
    public function append($str)
    {
        $this->str($str);
        $this->space();
        return $this;
    }

    /**
     * @param string $str
     * @return self
     */
    public function str($str)
    {
        $this->builder[] = $str;
        return $this;
    }

    /**
     * @return self
     */
    public function space()
    {
        $this->builder[] = ' ';
        return $this;
    }

    /**
     * @return string
     */
    function __toString()
    {
        $s = implode('', $this->builder);
        $s = trim($s);

        return $s;
    }

}
