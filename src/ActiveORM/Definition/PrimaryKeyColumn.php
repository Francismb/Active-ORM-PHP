<?php

namespace ActiveORM\Definition;

use ActiveORM\Exceptions\IncorrectDataTypeException;

/**
 * Class PrimaryKeyColumn.
 * @package ActiveORM\Definition
 */
class PrimaryKeyColumn extends Column
{
    /**
     * PrimaryKeyColumn constructor.
     * @param string $name The string to access the column.
     * @param string $columnName The name of the column.
     */
    public function __construct($name = 'id', $columnName = 'id')
    {
        parent::__construct($name, $columnName, null);
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
        if ($type == "int" || ($type == "string" && is_numeric($value)))
        {
            $this->value = $value;

            if ($originalValue)
            {
                $this->originalValue = $value;
            }
        }
        else
        {
            throw new IncorrectDataTypeException($this->getName(), $type);
        }
    }
}