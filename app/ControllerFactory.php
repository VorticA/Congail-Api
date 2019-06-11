<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/10/2019
 * Time: 3:41 PM
 */

namespace App;

use App\Controllers\Front\FrontUserHandler;
use App\Controllers\UserController;
use App\Database\DatabaseQueryer;
use App\Hash\Hasher;
use App\Repos\UserRepository;

include_once('pdo.php');

class ControllerFactory
{
    /**
     * @var \PDO
     */
    private $pdo;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function RunController($data)
    {
        if ($data['handler']=="user")
        {
            $handler = new FrontUserHandler(new UserController(new UserRepository(new DatabaseQueryer($this->pdo)), new Hasher(ENC_PREFIX, ENC_ALGO)), $_POST, $_SESSION);
            if ($data['method']=="login")
                $handler->loginHandler();
            else if ($data['method']=="register")
                $handler->registerHandler();
            else if ($data['method']=="home")
                $handler->homeHandler();
            else
                throw new \Exception("Invalid command!");
        }
    }
}