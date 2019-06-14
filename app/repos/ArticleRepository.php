<?php
/**
 * A repository class for making SQL queries to the "articles" table
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

    /**
     * Upon success returns an Article model with the given id
     */
    public function getArticleById($id)
    {
        return $this->queryer->prepare("SELECT id, title, text, DATE_FORMAT(post_date, '%d/%m/%Y %H:%i') AS postDate, poster_id AS posterId, is_deleted AS isDeleted FROM " . DB_NAME . "." . DB_ARTICLES . " WHERE id=?")->execute([$id])->fetchTo("App\\Models\\Article");
    }

    /**
     * Uploads a given Article model to the database (relies on validation from above)
     */
    public function uploadArticle(iArticle $article)
    {
        $this->queryer->
        prepare("INSERT INTO " . DB_NAME . "." . DB_ARTICLES . " SET title=?, text=?, post_date=DATE_ADD(now(), INTERVAL 8 HOUR), poster_id=?;")->
        execute([$article->getTitle(), $article->getText(), $article->getPosterId()]);

    }

    /**
     * Updates a given Article model in the database (relies on validation from above)
     */
    public function updateArticle(iArticle $article, int $id)
    {
        $this->queryer->
        prepare("UPDATE " . DB_NAME . "." . DB_ARTICLES . " SET title=?, text=?, post_date=DATE_ADD(now(), INTERVAL 8 HOUR) WHERE id=?;")->
        execute([$article->getTitle(), $article->getText(), $id]);
    }

    /**
     * Sets the "is_deleted" property to "1" on a given entry in the DB
     */
    public function deleteArticleById($id)
    {
        $this->queryer->prepare("UPDATE " . DB_NAME . "." . DB_ARTICLES . " SET is_deleted=1 WHERE id=?")->execute([$id]);
    }

    /**
     * Upon success returns an array with Article models ordered by date, with a specified limit to the amount of elements in the array.
     */
    public function getLatestArticles(int $limit)
    {
        return $this->queryer->prepare("SELECT id, title, text, DATE_FORMAT(post_date, '%d/%m/%Y %H:%i') AS postDate, poster_id AS posterId, is_deleted AS isDeleted FROM " . DB_NAME . "." . DB_ARTICLES . " WHERE is_deleted=0 ORDER BY postDate DESC LIMIT ?")->execute([$limit])->fetchAllTo("App\\Models\\Article");
    }
}