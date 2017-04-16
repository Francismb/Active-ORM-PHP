<?php
use ActiveORM\ActiveRecord;
use ActiveORM\ActiveRecordDefinition;
use ActiveORM\Definition\ForeignKeyColumn;
use ActiveORM\Definition\GenericColumn;
use ActiveORM\Definition\PrimaryKeyColumn;
use ActiveORM\Definition\Table;
use ActiveORM\Exceptions\ValidationException;
use ActiveORM\Relationships\BelongsTo;
use ActiveORM\Validation\ValidationError;

/**
 * Created by PhpStorm.
 * User: francis
 * Date: 4/14/17
 * Time: 11:45 AM
 */
class Job extends ActiveRecord
{
    public function validate()
    {
        $this->addPresenceValidator("title", "No job title specified");
        $this->addCustomValidator("The job salary is less than 50k", function() {
            return $this->salary > 50000;
        });
    }

    public static function define()
    {
        return new ActiveRecordDefinition(
            new Table('jobs', [
                new PrimaryKeyColumn(),
                new ForeignKeyColumn("user_id", "user_id"),
                new GenericColumn("title", "title", "string"),
                new GenericColumn("salary", "salary", "integer"),
            ]), [
                new BelongsTo("User", "user", "user_id")
            ]
        );
    }
}