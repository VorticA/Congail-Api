<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/15/2019
 * Time: 4:16 PM
 */

namespace App\Repos;


use App\Database\DatabaseQueryer;
use App\Models\iImage;

class ImageRepository implements iImageRepository
{

    /**
     * @var DatabaseQueryer
     */
    private $queryer;

    public function __construct(DatabaseQueryer $queryer)
    {
        $this->queryer = $queryer;
    }

    public function getImageById($id)
    {
        return $this->queryer->prepare("SELECT id, image_path AS path, image_title AS title, image_description AS description, 
          DATE_FORMAT(upload_date, '%d/%m/%Y %H:%i') AS date, is_deleted AS isDeleted, poster_id as posterId FROM " . DB_NAME . "." . DB_GALLERY . " WHERE id=?;")->
        execute([$id])->fetchTo("App\\Models\\Image");
    }

    public function uploadImage(iImage $image)
    {
        $this->queryer->prepare("INSERT INTO " . DB_NAME . "." . DB_GALLERY . " SET image_path=?, image_title=?, image_description=?, upload_date=DATE_ADD(now(), INTERVAL 8 HOUR), poster_id=?;")->
        execute([$image->getImagePath(), $image->getImageTitle(), $image->getImageDescription(), 1]);
    }

    public function updateImage(iImage $image, int $id)
    {
        $this->queryer->prepare("UPDATE " . DB_NAME . "." . DB_GALLERY . " SET image_title=?, image_description=?, upload_date=DATE_ADD(now(), INTERVAL 8 HOUR), poster_id=? WHERE id=?;")->
        execute([$image->getImageTitle(), $image->getImageDescription(), $image->getPosterId(), $id]);
    }

    public function deleteImageById($id)
    {
        $this->queryer->prepare("UPDATE " . DB_NAME . "." . DB_GALLERY . " SET is_deleted=1 WHERE id=?;")->execute([$id]);
    }

    public function getFullGallery()
    {
        return $this->queryer->prepare("SELECT id, image_path AS path, image_title AS title, image_description AS description, 
          DATE_FORMAT(upload_date, '%d/%m/%Y %H:%i') AS date, is_deleted AS isDeleted, poster_id as posterId FROM " . DB_NAME . "." . DB_GALLERY . " WHERE is_deleted=0")->execute()->fetchAllTo("App\\Models\\Image");
    }
}