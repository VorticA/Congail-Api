<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/10/2019
 * Time: 11:17 AM
 */

namespace App\Controllers;

use App\Models\iUser;

interface iUserController
{
    public function register(array $data);
    public function logInSession(array $data);
    public function getLoggedUserJson(array $data);
}