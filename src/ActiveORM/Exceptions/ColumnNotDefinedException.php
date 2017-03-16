<?php

namespace ActiveORM\Exceptions;

/**
 * Class ColumnNotDefinedException.
 * @package ActiveORM\Exceptions
 */
class ColumnNotDefinedException extends \Exception
{
    public function __construct($column)
    {
        parent::__construct("Column with the name '". $column ."' was not defined", 0, null);
    }
}