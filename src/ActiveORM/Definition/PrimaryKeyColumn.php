<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 3/16/17
 * Time: 12:33 PM
 */

namespace ActiveORM\Definition;


class PrimaryKeyColumn implements Column
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var int
     */
    private $value = null;

    /**
     * PrimaryKeyColumn constructor.
     * @param string $name The name of the column
     */
    public function __construct($name = 'id')
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getType()
    {
        return 'int';
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