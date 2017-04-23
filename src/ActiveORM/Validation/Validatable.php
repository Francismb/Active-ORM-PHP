<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 4/16/17
 * Time: 2:12 PM
 */

namespace ActiveORM\Validation;

trait Validatable
{
    /**
     * @var Validator[] The validators for this ActiveRecord.
     */
    private $validators = [];

    /**
     * @var string[] A string array of validation error messages
     */
    private $errors = [];

    /**
     * Checks to see if this is valid.
     * @return bool True if all validators return true.
     */
    public function valid()
    {
        $this->errors = [];
        foreach ($this->validators as $validator) {
            if (!$validator->valid()) {
                $this->errors[] = $validator->getErrorMessage();
            }
        }
        return count($this->errors) == 0;
    }

    /**
     * @param string $name The name of the attribute.
     * @param string $message The error message
     */
    public function addPresenceValidator($name, $message)
    {
        $this->validators[] = new PresenceValidator($name, $message, $this);
    }

    /**
     * @param string $message The error message.
     * @param \Closure $function The validation function.
     */
    public function addCustomValidator($message, $function)
    {
        $this->validators[] = new CustomValidator($message, $function);
    }

    /**
     * @return string[] an array of validation error messages.
     */
    public function getValidationErrors()
    {
        return $this->errors;
    }
}