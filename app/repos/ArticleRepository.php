<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/11/2019
 * Time: 3:33 PM
 */

namespace App\Repos;


use App\Database\iDatabaseQueryer;
use App\Models\iArticle;

class ArticleRepository implements iArticleRepository
{
    /**
     * @var iDatabaseQueryer
     */
    private $queryer;

    public function __construct(iDatabaseQueryer $queryer)
    {

        $this->queryer = $queryer;
    }

    public function getArticleById($id)
    {
        return $this->queryer->prepare("SELECT id, title, text, DATE_FORMAT(post_date, '%d/%m/%Y %H:%i') AS postDate, poster_id AS posterId, is_deleted AS isDeleted FROM " . DB_NAME . "." . DB_ARTICLES . " WHERE id=?")->execute([$id])->fetchTo("App\\Models\\Article");
    }

    public function uploadArticle(iArticle $article)
    {
        $this->queryer->
        prepare("INSERT INTO " . DB_NAME . "." . DB_ARTICLES . " SET title=?, text=?, post_date=DATE_ADD(now(), INTERVAL 8 HOUR), poster_id=?;")->
        execute([$article->getTitle(), $article->getText(), $article->getPosterId()]);

    }

    public function updateArticle(iArticle $article, int $id)
    {
        var_dump($article);
        $this->queryer->
        prepare("UPDATE " . DB_NAME . "." . DB_ARTICLES . " SET title=?, text=?, post_date=DATE_ADD(now(), INTERVAL 8 HOUR) WHERE id=?;")->
        execute([$article->getTitle(), $article->getText(), $id]);
    }

    public function deleteArticleById($id)
    {
        $this->queryer->prepare("UPDATE " . DB_NAME . "." . DB_ARTICLES . " SET is_deleted=1 WHERE id=?")->execute([$id]);
    }

    public function getLatestArticles(int $limit)
    {
        return $this->queryer->prepare("SELECT id, title, text, DATE_FORMAT(post_date, '%d/%m/%Y %H:%i') AS postDate, poster_id AS posterId, is_deleted AS isDeleted FROM " . DB_NAME . "." . DB_ARTICLES . " WHERE is_deleted=0 ORDER BY postDate DESC LIMIT ?")->execute([$limit])->fetchAllTo("App\\Models\\Article");
    }
}