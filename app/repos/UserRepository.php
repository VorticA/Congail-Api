<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/9/2019
 * Time: 4:41 PM
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

    public function getUserById(string $id)
    {
        return $this->getUser("WHERE (id=$id)");
    }

    public function getUserByUsername(string $username)
    {
        return $this->getUser("WHERE (username='$username')");
    }

    private function getUser(string $where="")
    {
        return $this->queryer->prepare("SELECT id, username, password, email, role_id AS roleId FROM " . DB_NAME . "." . DB_USERS . " " . $where . " LIMIT 1;")->execute()->fetchTo('App\\Models\\User');
    }

    public function importUser(iUser $user)
    {
        $this->queryer->prepare("INSERT INTO " . DB_NAME . "." . DB_USERS . " SET username=?, email=?, password=?;")->
        execute([$user->getUsername(), $user->getEmail(), $user->getPassword()]);
    }

    public function getUserByEmail(string $email)
    {
        return $this->getUser("WHERE (email=$email)");
    }
}
