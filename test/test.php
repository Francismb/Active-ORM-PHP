<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 3/16/17
 * Time: 10:07 AM
 */
require_once __DIR__ . '/../vendor/autoload.php';

$db = ActiveORM\ActiveRecordDB::initialize([
    'database_type' => 'sqlite',
    'database_file' => __DIR__ . '/../test/database.db'
]);

require_once "User.php";

// Clear user table
$users = User::findAll();
echo 'Loaded '. count($users) . ' users ' . "\n";
foreach ($users as $user)
{
    $user->delete();
}
echo 'Deleted all users' . "\n\n";

// Create a user 1 by using magic methods
$user = new User();
$user->email = "test@gmail.com12222";
$user->password = "supersecretpasswor1d";
$user->save();

// Verify if user 1 was created
if ($user->id != null) {
    echo 'User 1 saved successfully(ID='. $user->id .')' . "\n";
} else {
    die('Could not create user 1');
}

// Find the user we just created
$user = User::findOne(["email" => "test@gmail.com12222"]);
if ($user != null) {
    echo 'Found user 1(ID=' . $user->id . ' : EMAIL=' . $user->email . ')' . "\n\n";
} else {
    die('Could not find user 1');
}

// Create a user 2 by passing data to a constructor
$user2 = new User(["email" => "test@123mail.com", "password" => "supersecretpasswor1d"]);
$user2->save();

// Check if user 2 was created
if ($user2->id != null) {
    echo 'User 2 saved successfully(ID='. $user->id .')' . "\n\n";
} else {
    echo 'Could not create user 2';
}

// Find all users with the same password
$usersWithSamePassword = User::findAll(["password" => "supersecretpasswor1d"]);
echo 'Found ' . count($usersWithSamePassword) . ' Users with the password `supersecretpasswor1d`';