<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/9/2019
 * Time: 4:38 PM
 */
namespace App\Repos;

use App\Models\iUser;

interface iUserRepository
{
    public function getUserById(string $id);
    public function getUserByUsername(string $username);
    public function getUserByEmail(string $email);
    public function importUser(iUser $user);
}