<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 4/2/17
 * Time: 8:10 AM
 */

namespace ActiveORM\Exceptions;


class ValidationFailedException extends \Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}