<?php

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