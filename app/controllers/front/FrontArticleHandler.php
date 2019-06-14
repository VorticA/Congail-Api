<?php
/**
 * An HTTP handler for Article requests
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

    /**
     * Handles a request to get the latest articles.
     */
    public function latestHandler()
    {
        if(!isset($this->post['limit'])) throw new \Exception('Invalid info!');
        $this->controller->getLatestArticles($this->post['limit']);
    }

    /**
     * Handles a request to edit an article.
     */
    public function editHandler()
    {
        $this->controller->editArticle($this->post,$this->session);
    }

    /**
     * Handles a request to uplaod an article.
     */
    public function uploadHandler()
    {
        $this->controller->uploadArticle($this->post, $this->session);
    }

    /**
     * Handles a request to delete an article.
     */
    public function deleteHandler()
    {
        $this->controller->deleteArticle($this->post['id'], $this->session);
    }
}