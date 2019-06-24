<?php
/**
 * An MVC controller class for handling outside requests related to the database
 */

namespace App\Controllers;


use App\Hash\iHasher;
use App\Models\Article;
use App\Repos\iArticleRepository;
use App\Repos\iUserRepository;

class ArticlesController implements iArticlesController
{
    /**
     * @var iArticleRepository
     */
    private $articleRepository;
    /**
     * @var iUserRepository
     */
    private $userRepository;
    /**
     * @var iHasher
     */
    private $hasher;

    public function __construct(iArticleRepository $articleRepository, iUserRepository $userRepository, iHasher $hasher)
    {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
        $this->hasher = $hasher;
    }

    /**
     * Returns a JSON with the latest articles, with a limit to the amount of returned objects
     */
    public function getLatestArticles(int $limit)
    {
        $articles = $this->articleRepository->getLatestArticles($limit);
        $articlesArray = [];
        foreach ($articles as $article)
        {
            $poster = $this->getPoster($article->getPosterId())->getUsername();
            if (!isset($poster)) throw new \Exception("Invalid credentials.");
            $articleObj = [
                "id" => $article->getId(),
                "title" => $article->getTitle(),
                "text" => $article->getText(),
                "postDate" => $article->getPostDate(),
                "poster" => $poster
            ];
            array_push($articlesArray, $articleObj );
        }
        echo json_encode(["hasArticles" => true, "articles" => $articlesArray]);

    }


    /**
     * Processes and validates a request for article deletion.
     */
    public function deleteArticle(int $id, array $userData)
    {
        if ($this->isValidUser($userData))
        {
            $this->articleRepository->deleteArticleById($id);
        }
        else throw new \Exception("Invalid credentials.");
    }

    /**
     * Processes and validates a request for editing an article.
     */
    public function editArticle(array $articleData, array $userData)
    {
        if ($this->isValidUser($userData))
        {
            if (isset($articleData['title']) && isset($articleData['text']) && isset($articleData['id']))
            {
                $article = new Article($articleData['title'], $articleData['text']);
                $this->articleRepository->updateArticle($article, $articleData['id']);
            }
            else throw new \Exception("Invalid data.");
        }
        else throw new \Exception("Invalid credentials.");
    }

    /**
     * Processes and validates a request for article upload.
     */
    public function uploadArticle(array $articleData, array $userData)
    {
        if ($this->isValidUser($userData))
        {
            if ($this->isValidArticle($articleData))
            {
                $this->articleRepository->uploadArticle(new Article($articleData['title'], $articleData['text'], $userData['userId']));
            }

        }
        else throw new \Exception("Invalid credentials.");
    }

    /**
     * Validates if a valid user is logged in.
     */
    private function isValidUser(array $data)
    {
        if (isset($data['userId']) && isset($data['password'])) {
            $user = $this->userRepository->getUserById($data['userId']);
            if (isset($user))
            {
                if ($this->hasher->MatchPasswords($data['password'], $user->getPassword()) && $user->getRoleId()!=3) {
                    return true;
                }
                return false;
            }
            return false;
        }

        return false;
    }

    /**
     * Returns a User model, who is the supposed poster of the article.
     */
    private function getPoster(int $id)
    {
        return $this->userRepository->getUserById($id);
    }

    /**
     * Simple field validation.
     */
    private function isValidArticle(array $articleData)
    {
        if (isset($articleData['title']) && isset($articleData['text']))
            return true;
        return false;
    }

}