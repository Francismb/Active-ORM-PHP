<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 4/14/17
 * Time: 3:17 PM
 */

use ActiveORM\ActiveRecord;
use ActiveORM\ActiveRecordDefinition;
use ActiveORM\Definition\GenericColumn;
use ActiveORM\Definition\PrimaryKeyColumn;
use ActiveORM\Definition\Table;
use ActiveORM\Relationships\HasMany;

class InternetProvider extends ActiveRecord
{
    public static function define()
    {
        return new ActiveRecordDefinition(
            new Table('internetprovider', [
                new PrimaryKeyColumn(),
                new GenericColumn("name", "name", "string"),
            ]), [
                new HasMany("User", "users", "internetprovider_id"),
                new HasMany("House", "houses", "internetprovider_id")
            ]
        );
    }
}