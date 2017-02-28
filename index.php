<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 2/28/17
 * Time: 12:21 PM
 */
require 'vendor/autoload.php';
require 'models/ActiveORM.php';
require 'models/User.php';

use Medoo\Medoo;

$GLOBALS['database'] = new Medoo([
    'database_type' => 'sqlite',
    'database_file' => 'database.db'
]);

// Create and save a user to the database
$user = new User();
$user->email = "user@email.com";
$user->password = "supersecretpassword";
$user->save();

// Load the user back from the databsae
$user = User::findOne(["email" => "user@email.com"]);
echo $user->email; //prints user@email.com

// Deletes the user from the database
$user->delete();

$user = User::findOne(["email" => "user@email.com"]);
if ($user) {
    echo 'user found';
} else {
    echo 'user not found';
}
// Prints user not found