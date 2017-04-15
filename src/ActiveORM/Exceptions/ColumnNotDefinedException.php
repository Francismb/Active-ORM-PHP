<?php

namespace ActiveORM\Exceptions;

/**
 * Class ColumnNotDefinedException.
 * @package ActiveORM\Exceptions
 */
class ColumnNotDefinedException extends \Exception
{
    public function __construct($table, $column)
    {
        parent::__construct("Could not find column with name '". $column ."' in the table '". $table ."'", 0, null);
    }
}