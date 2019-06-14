<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/14/2019
 * Time: 1:03 PM
 */

namespace App\Controllers\Front;


use App\Controllers\iArticlesController;

class FrontArticleHandler implements iFrontArticleHandler
{

    /**
     * @var iArticlesController
     */
    private $controller;
    /**
     * @var array
     */
    private $post;
    /**
     * @var array
     */
    private $session;

    public function __construct(iArticlesController $controller, array $post, array $session)
    {
        $this->controller = $controller;
        $this->post = $post;
        $this->session = $session;
    }

    public function latestHandler()
    {
        if(!isset($this->post['limit'])) throw new \Exception('Invalid info!');
        $this->controller->getLatestArticles($this->post['limit']);
    }

    public function editHandler()
    {
        $this->controller->editArticle($this->post,$this->session);
    }

    public function uploadHandler()
    {
        $this->controller->uploadArticle($this->post, $this->session);
    }

    public function deleteHandler()
    {
        $this->controller->deleteArticle($this->post['id'], $this->session);
    }
}