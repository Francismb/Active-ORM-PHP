<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 3/16/17
 * Time: 12:30 PM
 */

namespace ActiveORM\Definition;


class GenericColumn implements Column
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $type;

    /**
     * @var mixed
     */
    private $value;

    /**
     * GenericColumn constructor.
     * @param string $name The name of the column
     * @param string $type The data type of the column
     */
    public function __construct($name, $type)
    {
        $this->name = $name;
        $this->type = $type;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }
}