<?php
/**
 * A "factory" class which, based on the given information from a router,
 * decides which HTTP handler should be initialized and which method should be called.
 */

namespace App;

use App\Controllers\ArticlesController;
use App\Controllers\Front\FrontArticleHandler;
use App\Controllers\Front\FrontImageHandler;
use App\Controllers\Front\FrontUserHandler;
use App\Controllers\ImageController;
use App\Controllers\UserController;
use App\Database\DatabaseQueryer;
use App\Hash\Hasher;
use App\Repos\ArticleRepository;
use App\Repos\ImageRepository;
use App\Repos\UserRepository;
use App\Service\ImageUploadService;

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

    /**
     * Simply runs the factory, which is a bunch of "if else" statements.
     */
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
        else if ($data['handler']=="image")
        {
            $hasher = new Hasher(ENC_PREFIX, ENC_ALGO);
            $db = new DatabaseQueryer($this->pdo);
            $imgrepo = new ImageRepository($db);
            $userrepo = new UserRepository($db);
            $service = new ImageUploadService($hasher, FILES_FOULDER);
            $ctrl = new ImageController($imgrepo, $userrepo, $service, $hasher);
            $handler = new FrontImageHandler($ctrl, $_POST, $_SESSION, $_FILES);
            if ($data['method']=="edit")
            {
                $handler->editHandler();
            }
            else if($data['method']=="upload")
            {
                $handler->uploadHandler();
            }
            else if ($data['method']=="delete")
            {
                $handler->deleteHandler();
            }
            else if ($data['method']=="gallery")
            {
                $handler->galleryHandler();
            }
            else throw new \Exception("Invalid command!");
        }
        else
            throw new \Exception("Invalid command!");
    }
}