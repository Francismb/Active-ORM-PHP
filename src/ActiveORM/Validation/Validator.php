<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 4/16/17
 * Time: 2:27 PM
 */

namespace ActiveORM\Validation;


use ActiveORM\ActiveRecord;

abstract class Validator
{
    /**
     * @var string The name of the variable which we are doing validation on.
     */
    protected $name;

    /**
     * @var string The error message if this validation fails.
     */
    protected $message;

    /**
     * @var ActiveRecord The active record that we are doing validation on.
     */
    protected $activeRecord;

    /**
     * Validator constructor.
     * @param string $name The name of the variable which we are doing validation on.
     * @param string $message The error message if this validation fails.
     * @param ActiveRecord $activeRecord The active record that we are doing validation on.
     */
    public function __construct($name, $message, $activeRecord)
    {
        $this->name = $name;
        $this->message = $message;
        $this->activeRecord = $activeRecord;
    }

    /**
     * Checks to see if this validator is valid.
     */
    public abstract function valid();

    /**
     * @return string The error message.
     */
    public function getErrorMessage()
    {
        return $this->message;
    }
}