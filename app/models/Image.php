<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/15/2019
 * Time: 3:39 PM
 */

namespace App\Models;


class Image implements iImage
{
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $date;
    /**
     * @var int
     */
    private $isDeleted;
    /**
     * @var int
     */
    private $posterId;

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $path;

    public function __construct(string $title="", string $description="", string $path="", string $date="", int $isDeleted=0, int $posterId=0)
    {
        $this->title = $title;
        $this->description = $description;
        $this->date = $date;
        $this->isDeleted = $isDeleted;
        $this->posterId = $posterId;
        $this->path = $path;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getImagePath()
    {
        return $this->path;
    }

    public function getImageTitle()
    {
        return $this->title;
    }

    public function getImageDescription()
    {
        return $this->description;
    }

    public function getIsDeleted()
    {
        return $this->isDeleted;
    }

    public function getPosterId()
    {
        return $this->posterId;
    }

    public function getUploadDate()
    {
        return $this->date;
    }
}