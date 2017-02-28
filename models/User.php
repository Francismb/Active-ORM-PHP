<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 2/28/17
 * Time: 1:23 PM
 */
class User extends \ActiveORM
{

    protected static $table = 'users';

    private $id;
    private $email;
    private $password;

}