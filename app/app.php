<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/8/2019
 * Time: 12:40 PM
 */
namespace App;
session_start();
spl_autoload_register();

use App\Controllers\UserController;
use \App\Database\DatabaseQueryer;
use \App\Database\DatabaseStatement;
use \App\Database\DatabaseResult;
use App\Hash\Hasher;
use App\Models\User;
use App\Repos\UserRepository;

$app = new Application();
$app->run();
