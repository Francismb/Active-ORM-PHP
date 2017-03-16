<?php

/**
 * Created by PhpStorm.
 * User: francis
 * Date: 2/28/17
 * Time: 1:23 PM
 */
class User extends ActiveORM\ActiveRecord
{
    public static function define()
    {
        return new ActiveORM\Definition\Table("users", [
                new ActiveORM\Definition\PrimaryKeyColumn(),
                new ActiveORM\Definition\GenericColumn("email", "string"),
                new ActiveORM\Definition\GenericColumn("password", "string")
        ]);
    }
}