<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/12/2019
 * Time: 1:55 PM
 */

namespace App\Controllers;


interface iArticlesController
{
    public function uploadArticle(array $articleData, array $userData);
    public function getLatestArticles(int $limit);
    public function deleteArticle(int $id, array $userData);
    public function editArticle(array $articleData, array $userData);
}