<?php

namespace ActiveORM\Definition;

use ActiveORM\Exceptions\IncorrectDataTypeException;

/**
 * Class PrimaryKeyColumn.
 * @package ActiveORM\Definition
 */
class ForeignKeyColumn extends Column
{
    /**
     * PrimaryKeyColumn constructor.
     * @param string $name The name of this column used to access it.
     * @param string $columnName The name of the column in the database.
     */
    public function __construct($name, $columnName)
    {
        parent::__construct($name, $columnName, null);
    }

    /**
     * Sets the value of the column.
     * @param int|string $value The value of the column.
     * @param bool $originalValue Determines if this is the original value
     * @throws IncorrectDataTypeException
     */
    public function setValue($value, $originalValue = false)
    {
        if ($value == null)
        {
            return;
        }

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
            throw new IncorrectDataTypeException($this->getName(), "int|string", $type);
        }
    }
}