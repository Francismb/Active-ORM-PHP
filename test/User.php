<?php

use ActiveORM\ActiveRecord;
use ActiveORM\Definition\ForeignKeyColumn;
use ActiveORM\Definition\Table;
use ActiveORM\Definition\PrimaryKeyColumn;
use ActiveORM\Definition\GenericColumn;
use ActiveORM\Relationships\BelongsTo;
use ActiveORM\Relationships\HasMany;

class User extends ActiveRecord
{
    public static function define()
    {
        return new \ActiveORM\ActiveRecordDefinition(
            new Table('users', [
                new PrimaryKeyColumn(),
                new ForeignKeyColumn("internetprovider_id", "internetprovider_id"),
                new GenericColumn("email", "email", "string"),
                new GenericColumn("password", "password_digest", "string"),
            ]), [
                new HasMany("House", "houses", "user_id"),
                new BelongsTo("InternetProvider", "internetProvider", "internetprovider_id")
            ]
        );
    }
}