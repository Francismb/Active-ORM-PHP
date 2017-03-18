<?php

namespace ActiveORM\Definition;

/**
 * Class PrimaryKeyColumn.
 * @package ActiveORM\Definition
 */
class PrimaryKeyColumn implements Column
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $value = null;

    /**
     * PrimaryKeyColumn constructor.
     * @param string $name The name of the column
     */
    public function __construct($name = 'id')
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return 'integer';
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $type = gettype($value);
        if ($this->getType() == $type)
        {
            $this->value = $value;
        }
        else
        {
            throw new \ActiveORM\Exceptions\IncorrectDataTypeException($this->getName(), $type);
        }
    }
}