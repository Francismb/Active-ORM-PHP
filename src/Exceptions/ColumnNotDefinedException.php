<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 3/8/17
 * Time: 12:58 PM
 */

namespace Exceptions;

class ColumnNotDefinedException extends \Exception
{
    public function __construct($column)
    {
        parent::__construct("Column with the name '". $column ."' was not defined", 0, null);
    }
}