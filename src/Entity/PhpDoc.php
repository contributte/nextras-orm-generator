<?php

namespace Contributte\Nextras\Orm\Generator\Entity;

use Contributte\Nextras\Orm\Generator\Utils\DocBuilder;

class PhpDoc
{

    /** @var string */
    private $annotation;

    /** @var string */
    private $type;

    /** @var string */
    private $variable;

    /** @var string */
    private $enum;

    /** @var string */
    private $default;

    /** @var bool */
    private $virtual;

    /** @var PhpRelDoc */
    private $relation;

    /**
     * @return string
     */
    public function getAnnotation()
    {
        return $this->annotation;
    }

    /**
     * @param string $annotation
     */
    public function setAnnotation($annotation)
    {
        $this->annotation = $annotation;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getVariable()
    {
        return $this->variable;
    }

    /**
     * @param string $variable
     */
    public function setVariable($variable)
    {
        $this->variable = $variable;
    }

    /**
     * @return string
     */
    public function getEnum()
    {
        return $this->enum;
    }

    /**
     * @param string $enum
     */
    public function setEnum($enum)
    {
        $this->enum = $enum;
    }

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param string $default
     */
    public function setDefault($default)
    {
        $this->default = $default;
    }

    /**
     * @return boolean
     */
    public function isVirtual()
    {
        return $this->virtual;
    }

    /**
     * @param boolean $virtual
     */
    public function setVirtual($virtual)
    {
        $this->virtual = (bool)$virtual;
    }

    /**
     * @return PhpRelDoc
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * @param PhpRelDoc $relation
     */
    public function setRelation($relation)
    {
        $this->relation = $relation;
    }

    /**
     * @return string
     */
    function __toString()
    {
        $b = new DocBuilder();

        // Anotation (@..)
        if ($this->annotation) {
            $b->append($this->annotation);
        } else {
            if ($this->virtual) {
                $b->append('@property-read');
            } else {
                $b->append('@property');
            }
        }

        // Type (int, string..)
        $b->append($this->type);

        // Variable ($..)
        $b->append(sprintf('$%s', $this->variable));

        // Default
        if ($this->default) {
            $b->append(sprintf('{default %s}', $this->default));
        }

        // Enum {enum ..}
        if ($this->enum) {
            $b->append(sprintf('{enum self::%s_*}', $this->enum));
        }

        // Virtual
        if ($this->virtual) {
            $b->append('{virtual}');
        }

        // Relation
        if ($this->relation) {
            $b->append(sprintf('{%s}', (string)$this->relation));
        }

        return (string)$b;
    }

}
