<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/11/2019
 * Time: 3:28 PM
 */

namespace App\Repos;


use App\Models\iArticle;

interface iArticleRepository
{
    public function getArticleById($id);
    public function uploadArticle(iArticle $article);
    public function updateArticle(iArticle $article, int $id);
    public function deleteArticleById($id);
    public function getLatestArticles(int $limit);
}