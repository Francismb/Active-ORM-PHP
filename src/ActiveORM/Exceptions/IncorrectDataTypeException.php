<?php

namespace ActiveORM\Exceptions;

/**
 * Class IncorrectDataTypeException.
 * @package ActiveORM\Exceptions
 */
class IncorrectDataTypeException extends \Exception
{
    public function __construct($column, $expectedType, $type)
    {
        parent::__construct($column . " column was meant to be of data type '". $expectedType ."' but was of data type '". $type ."'");
    }
}