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

            $router = new Router(new ControllerFactory($pdo));
            $router->Route();
        }
        catch (\Exception $e)
        {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}