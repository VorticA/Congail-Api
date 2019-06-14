<?php
/**
 * A repository class for making SQL queries to the "users" table
 */

namespace App\Repos;


use App\Database\iDatabaseQueryer;
use App\Models\iUser;
use App\Models\User;


class UserRepository implements iUserRepository
{
    /**
     * @var iDatabaseQueryer
     */
    private $queryer;

    public function __construct(iDatabaseQueryer $queryer)
    {
        $this->queryer = $queryer;
    }

    /**
     * Upon success returns a User model with the given id
     */
    public function getUserById(string $id)
    {
        return $this->getUser("WHERE (id=$id)");
    }

    /**
     * Upon success returns a User model with the given username
     */
    public function getUserByUsername(string $username)
    {
        return $this->getUser("WHERE (username='$username')");
    }

    /**
     * Upon success returns a User model with the given email
     */
    public function getUserByEmail(string $email)
    {
        return $this->getUser("WHERE (email=$email)");
    }

    /**
     * A private function used for generalising querries and avoiding code repetition.
     */
    private function getUser(string $where="")
    {
        return $this->queryer->prepare("SELECT id, username, password, email, role_id AS roleId FROM " . DB_NAME . "." . DB_USERS . " " . $where . " LIMIT 1;")->execute()->fetchTo('App\\Models\\User');
    }

    /**
     * Imports a supposed User model to the database (relies on validation from above)
     */
    public function importUser(iUser $user)
    {
        $this->queryer->prepare("INSERT INTO " . DB_NAME . "." . DB_USERS . " SET username=?, email=?, password=?;")->
        execute([$user->getUsername(), $user->getEmail(), $user->getPassword()]);
    }

}
