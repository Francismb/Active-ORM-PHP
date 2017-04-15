<?php

namespace ActiveORM\Definition;

use ActiveORM\Exceptions\IncorrectDataTypeException;

/**
 * Class GenericColumn.
 * @package ActiveORM\Definition
 */
class GenericColumn extends Column
{
    /**
     * GenericColumn constructor.
     * @param string $name The string to access this column.
     * @param string $columnName The name of the column.
     * @param string $type The data type of the column.
     */
    public function __construct($name, $columnName, $type)
    {
        parent::__construct($name, $columnName, $type);
    }

    /**
     * Sets the value of the column.
     * @param mixed $value The value of the column.
     * @param bool $originalValue Determines if this is the original value
     * @throws IncorrectDataTypeException
     */
    public function setValue($value, $originalValue = false)
    {
        $type = gettype($value);
        if ($type == $this->type || settype($value, $this->type))
        {
            $this->value = $value;

            if ($originalValue)
            {
                $this->originalValue = $value;
            }
        }
        else
        {
            throw new IncorrectDataTypeException($this->getName(), $this->type, $type);
        }
    }
}