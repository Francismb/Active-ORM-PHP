<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 4/16/17
 * Time: 2:30 PM
 */

namespace ActiveORM\Validation;

class CustomValidator extends Validator
{

    /**
     * @var function The custom validation function.
     */
    private $function;

    /**
     * PresenceValidator constructor.
     * @param string $message The error message if this validation fails.
     * @param $function
     */
    public function __construct($message, $function)
    {
        parent::__construct(null, $message, null);
        $this->function = $function;
    }

    /**
     * Checks to see if this validator is valid.
     */
    public function valid()
    {
        return call_user_func($this->function);
    }
}