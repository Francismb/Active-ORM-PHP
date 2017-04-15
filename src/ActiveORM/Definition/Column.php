<?php

namespace ActiveORM\Definition;

/**
 * Interface Column.
 * @package ActiveORM\Definition
 */
interface Column
{
    /**
     * Returns the name we use to access the column.
     * @return string The name used to access the column.
     */
    public function getName();

    /**
     * Returns the name of the column in the table.
     * @return string The name of the column
     */
    public function getColumnName();

    /**
     * Returns the value of the column.
     * @return mixed The value of the column.
     */
    public function getValue();

    /**
     * Sets the value of the column.
     * @param mixed $value The value of the column.
     * @param bool $originalValue Determines if this is the original value
     * @return
     */
    public function setValue($value, $originalValue = false);

    /**
     * Checks to see if the column has been modified.
     * @return bool
     */
    public function hasBeenUpdated();
}