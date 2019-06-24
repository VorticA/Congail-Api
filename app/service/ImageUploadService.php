<?php

namespace App\Service;
use App\Hash\iHasher;

/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/15/2019
 * Time: 2:00 PM
 */


class ImageUploadService implements iImageUploadService
{

    /**
     * @var iHasher
     */
    private $hasher;
    /**
     * @var string
     */
    private $fileFoulder;

    public function __construct(iHasher $hasher, string $fileFoulder)
    {

        $this->hasher = $hasher;
        $this->fileFoulder = $fileFoulder;
    }

    public function AttemptUploadFile(array $fileData, string $target): bool
    {
        if (!$this->isValidFile($fileData))
            return false;
        move_uploaded_file($fileData['tmp_name'], $this->fileFoulder . "/" . $target);
        return true;
    }

    public function isValidFile(array $fileData): bool
    {
        if (!isset($fileData))
            return false;
        if (!getimagesize($fileData["tmp_name"]))
            return false;
        return true;
    }

    public function generateFileName(array $fileData)
    {
        if ($this->isValidFile($fileData))
        {
            $imageFileType = strtolower(pathinfo($fileData['name'], PATHINFO_EXTENSION));
            return str_replace("/", "", $this->hasher->EncodePassword(basename($_FILES["fileToUpload"]["name"]) . rand())) . "." . $imageFileType;
        }
        return "";
    }
}