<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/10/2019
 * Time: 3:41 PM
 */

namespace App;

use App\Controllers\ArticlesController;
use App\Controllers\Front\FrontArticleHandler;
use App\Controllers\Front\FrontUserHandler;
use App\Controllers\UserController;
use App\Database\DatabaseQueryer;
use App\Hash\Hasher;
use App\Repos\ArticleRepository;
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
        else if($data['handler']=="article")
        {
            $db = new DatabaseQueryer($this->pdo);
            $hasher = new Hasher(ENC_PREFIX, ENC_ALGO);
            $articleRepo = new ArticleRepository($db);
            $userRepo = new UserRepository($db);
            $articleController = new ArticlesController($articleRepo, $userRepo, $hasher);
            $handler = new FrontArticleHandler($articleController, $_POST, $_SESSION);
            if ($data['method']=="latest")
                $handler->latestHandler();
            else if($data['method']=="edit")
                $handler->editHandler();
            else if($data['method']=="delete")
                $handler->deleteHandler();
            else if($data['method']=="upload")
                $handler->uploadHandler();
            else throw new \Exception("Invalid command!");
        }
        else
            throw new \Exception("Invalid command!");
    }
}