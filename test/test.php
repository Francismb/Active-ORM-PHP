<?php
/**
 * Created by PhpStorm.
 * User: francis
 * Date: 3/16/17
 * Time: 10:07 AM
 */
require_once __DIR__ . '/../vendor/autoload.php';

ActiveORM\ActiveRecordDB::initialize([
    'database_type' => 'sqlite',
    'database_file' => __DIR__ . '/../test/database.db'
]);

require_once "User.php";
require_once "House.php";
require_once "InternetProvider.php";
require_once "Job.php";

function clearDatabase()
{
    \ActiveORM\ActiveRecordDB::getDatabase()->delete("users", []);
    \ActiveORM\ActiveRecordDB::getDatabase()->delete("houses", []);
    \ActiveORM\ActiveRecordDB::getDatabase()->delete("internetproviders", []);
    \ActiveORM\ActiveRecordDB::getDatabase()->delete("jobs", []);
}

/**
 * Generic ORM functionality
 */
clearDatabase();

$user = new User();
$user->email = "test@gmail.com12222";
$user->password = "supersecretpasswor1d";
$user->save();

if ($user->id == null) {
    die('ERROR - Could not create user 1');
}

$user = User::findOne(["email" => "test@gmail.com12222"]);
if ($user == null) {
    die('ERROR - Could not find user 1');
}

$user2 = new User(["email" => "test@123mail.com", "password" => "supersecretpasswor1d"]);
$user2->save();

if ($user2->id == null) {
    die('ERROR - Could not create user 2');
}

if (!User::exists(['email' => 'test@gmail.com12222']))
{
    die('ERROR - Could not fnd user with email of test@gmail.com12222');
}

if (!User::count())
{
    die('ERROR - Could not count any users');
}

$usersWithSamePassword = User::findAll(["password_digest" => "supersecretpasswor1d"]);
if (!count($usersWithSamePassword))
{
    die('ERROR - Could not find any users with the same password');
}

/**
 * Relationship ORM functionality
 */
clearDatabase();

$user = new User();
$user->email = "test@gmail.com12222";
$user->password = "supersecretpasswor1d";

// Has many test
$house1 = new House(["address" => "123 Standmore Road"]);
$house2 = new House(["address" => "Some odd asf address"]);

$internetProvider = new InternetProvider(["name" => "Telecom"]);

$job = new Job(["title" => "Senior Software Engineer", "salary" => 100000]);

$user->houses[] = $house1;
$user->houses[] = $house2;

$user->internetProvider = $internetProvider;

$user->job = $job;

$user->save();

$user = User::findByID(1);

if ($user == null)
{
    die('ERROR - Could not load user');
}

if (count($user->houses) != 2)
{
    die('ERROR - User does not have two houses');
}

if ($user->internetProvider == null)
{
    die('ERROR - User does not have internet provider');
}

if ($user->job == null)
{
    die('ERROR - User does not have a job');
}

/**
 * Validation tests
 */

clearDatabase();

$newJob = new Job();
$newJob->salary = 25000;

if ($newJob->valid())
{
    die('ERROR - Job is not meant to be valid');
}

if (count($newJob->getValidationErrors()) != 2)
{
    die('ERROR - Job is meant to have two validation errors');
}

$secondJob = new Job();
$secondJob->salary = 150000;
$secondJob->title = "Expert Noob";

if (!$secondJob->valid())
{
    die('ERROR- Job was meant to be valid');
}

$secondJob->save();

if (!$secondJob->id)
{
    die('Could not save job');
}

echo "\n\nAll tests passed";

/**
 * Test transaction
 */
clearDatabase();
\ActiveORM\ActiveRecordDB::getDatabase()->action(function ($database) {
    $database->insert("users", [
        "email" => "foo",
        "password_digest" => "testtttt"
    ]);
    $user_id = $database->id();
    $database->insert("houses", [
        "user_id" => $user_id,
        "address" => "testtttt"
    ]);
});