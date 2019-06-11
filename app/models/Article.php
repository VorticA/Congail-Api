<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/11/2019
 * Time: 3:15 PM
 */

namespace App\Models;


class Article implements iArticle
{

    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $text;
    /**
     * @var int
     */
    private $posterId;
    /**
     * @var int
     */
    private $isDeleted;

    /**
     * @var int
     */
    private $id;

    /**
     * string
     */
    private $postDate;

    public function __construct(string $title="", string $text="", string $posterId="", int $isDeleted=0)
    {

        $this->title = $title;
        $this->text = $text;
        $this->posterId = $posterId;
        $this->isDeleted = $isDeleted;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getText()
    {
        return $this->text;
    }

    public function getPostDate()
    {
        return $this->postDate;
    }

    public function getPosterId()
    {
        return $this->posterId;
    }

    public function getIsDeleted()
    {
        return $this->isDeleted;
    }
}