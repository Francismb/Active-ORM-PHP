<?php

namespace ActiveORM\Definition;

/**
 * Class GenericColumn.
 * @package ActiveORM\Definition
 */
class GenericColumn implements Column
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var mixed
     */
    private $value;

    /**
     * GenericColumn constructor.
     * @param string $name The name of the column
     * @param string $type The data type of the column
     */
    public function __construct($name, $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $type = gettype($value);
        if ($type == $this->getType())
        {
            $this->value = $value;
        }
        else
        {
            throw new \ActiveORM\Exceptions\IncorrectDataTypeException($this->getName(), $type);
        }
    }
}