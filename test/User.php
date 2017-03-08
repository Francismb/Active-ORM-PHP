<?php

/**
 * Created by PhpStorm.
 * User: francis
 * Date: 2/28/17
 * Time: 1:23 PM
 */
class User extends ActiveRecord
{
    public static function define()
    {
        return new \Definition\Table("users", [
                \Definition\Column::primary("id"),
                \Definition\Column::generic("email", "string"),
                \Definition\Column::generic("password", "string")
        ]);
    }
}