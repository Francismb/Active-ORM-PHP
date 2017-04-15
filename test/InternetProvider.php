<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 4/14/17
 * Time: 3:17 PM
 */

use ActiveORM\ActiveRecord;
use ActiveORM\ActiveRecordDefinition;
use ActiveORM\Definition\ForeignKeyColumn;
use ActiveORM\Definition\GenericColumn;
use ActiveORM\Definition\PrimaryKeyColumn;
use ActiveORM\Definition\Table;
use ActiveORM\Relationships\HasMany;

class InternetProvider extends ActiveRecord
{
    public static function define()
    {
        return new ActiveRecordDefinition(
            new Table('houses', [
                new PrimaryKeyColumn(),
                new GenericColumn("name", "name", "string"),
            ]), [
                new HasMany("User", "users", "user_id"),
                new HasMany("House", "houses", "house_id")
            ]
        );
    }
}