<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/9/2019
 * Time: 4:25 PM
 */

namespace App;


use App\Database\DatabaseQueryer;
use App\Models\Article;
use App\Repos\ArticleRepository;

class Application
{
    public function run(){
        try
        {
            include_once('pdo.php');

            //$router = new Router(new ControllerFactory($pdo));
            //$router->Route();

            $repo = new ArticleRepository(new DatabaseQueryer($pdo));
            $article = new Article("Goshko", "Goshko is a bad boy", 7);
            var_dump($repo->getLatestArticles(2));
        }
        catch (\Exception $e)
        {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}