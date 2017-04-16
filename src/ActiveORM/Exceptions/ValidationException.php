<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 4/2/17
 * Time: 8:10 AM
 */

namespace ActiveORM\Exceptions;

/**
 * Class ValidationFailedException.
 * @package ActiveORM\Exceptions
 */
class ValidationException extends \Exception
{
    private $message;

    public function __construct($message)
    {
        parent::__construct($message);
        $this->message = $message;
    }
}