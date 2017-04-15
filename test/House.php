<?php
use ActiveORM\ActiveRecord;
use ActiveORM\ActiveRecordDefinition;
use ActiveORM\Definition\ForeignKeyColumn;
use ActiveORM\Definition\GenericColumn;
use ActiveORM\Definition\PrimaryKeyColumn;
use ActiveORM\Definition\Table;
use ActiveORM\Relationships\BelongsTo;

/**
 * Created by PhpStorm.
 * User: francis
 * Date: 4/14/17
 * Time: 11:45 AM
 */
class House extends ActiveRecord
{
    public static function define()
    {
        return new ActiveRecordDefinition(
            new Table('houses', [
                new PrimaryKeyColumn(),
                new ForeignKeyColumn("user_id", "user_id"),
                new ForeignKeyColumn("internetprovider_id", "internetprovider_id"),
                new GenericColumn("address", "address", "string"),
            ]), [
                new BelongsTo("User", "user", "user_id"),
                new BelongsTo("InternetProvider", "internetProvider", "internetprovider_id")
            ]
        );
    }
}