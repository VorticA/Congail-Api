<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/9/2019
 * Time: 4:25 PM
 */

namespace App;


use App\Controllers\ArticlesController;
use App\Database\DatabaseQueryer;
use App\Hash\Hasher;
use App\Models\Article;
use App\Repos\ArticleRepository;
use App\Repos\UserRepository;

class Application
{
    public function run(){
        try
        {
            include_once('pdo.php');

            //$router = new Router(new ControllerFactory($pdo));
            //$router->Route();
            $testpdo = new \PDO("mysql:host=" . DB_URL . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
            $queryer = new DatabaseQueryer($testpdo);
            $articleRepo = new ArticleRepository($queryer);
            $userRepo = new UserRepository($queryer);
            $hasher = new Hasher(ENC_PREFIX, ENC_ALGO);

            $controller = new ArticlesController($articleRepo, $userRepo, $hasher);
            $controller->uploadArticle(['title'=>'Pesho', 'text'=>'Pesho is another boy.'], ['userId'=>'7', 'password'=>'passwordforadmin']);
        }
        catch (\Exception $e)
        {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}