<?php

namespace ActiveORM\Definition;

/**
 * Interface Column.
 * @package ActiveORM\Definition
 */
interface Column
{
    /**
     * Returns the name of the column.
     * @return string The name of the column.
     */
    public function getName();

    /**
     * Returns the data type of the column.
     * @return string The data type of the column.
     */
    public function getType();

    /**
     * Returns the value of the column.
     * @return mixed The value of the column.
     */
    public function getValue();

    /**
     * Sets the value of the column.
     * @param mixed $value The value of the column.
     */
    public function setValue($value);
}