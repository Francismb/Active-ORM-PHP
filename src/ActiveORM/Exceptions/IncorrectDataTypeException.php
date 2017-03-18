<?php

namespace ActiveORM\Exceptions;

/**
 * Class IncorrectDataTypeException.
 * @package ActiveORM\Exceptions
 */
class IncorrectDataTypeException extends \Exception
{
    public function __construct($column, $type)
    {
        parent::__construct($column . ' column is not the data type ' . $type);
    }
}