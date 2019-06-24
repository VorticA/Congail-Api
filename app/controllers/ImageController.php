<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/23/2019
 * Time: 12:54 PM
 */

namespace App\Controllers;


use App\Hash\iHasher;
use App\Models\Image;
use App\Repos\iImageRepository;
use App\Repos\iUserRepository;
use App\Service\iImageUploadService;

class ImageController implements iImageController
{

    /**
     * @var iImageRepository
     */
    private $imageRepository;
    /**
     * @var iUserRepository
     */
    private $userRepository;
    /**
     * @var iImageUploadService
     */
    private $imageUploadService;
    /**
     * @var iHasher
     */
    private $hasher;

    public function __construct(iImageRepository $imageRepository, iUserRepository $userRepository, iImageUploadService $imageUploadService, iHasher $hasher)
    {
        $this->imageRepository = $imageRepository;
        $this->userRepository = $userRepository;
        $this->imageUploadService = $imageUploadService;
        $this->hasher = $hasher;
    }

    public function uploadImage(array $imageData, array $files, array $userData)
    {
        if ($this->isValidUser($userData))
        {
            if (isset($files['fileToUpload']) && $this->imageUploadService->isValidFile($files['fileToUpload']))
            {
                if ($this->validateImageData($imageData))
                {
                    $name = $this->imageUploadService->generateFileName($files['fileToUpload']);
                    if ($this->imageUploadService->AttemptUploadFile($files['fileToUpload'], $name))
                    {
                        $this->imageRepository->uploadImage(new Image($imageData['title'], $imageData['description'], $name));
                    } else throw new \Exception("Error uploading file.");
                } else throw new \Exception("Invalid data.");
            }
            else throw new \Exception("Invalid data.");
        }
        else throw new \Exception("Invalid credentials.");
    }

    public function getFullGallery()
    {
        $gallery = $this->imageRepository->getFullGallery();
        $imageArray = [];
        foreach ($gallery as $image)
        {
            $poster = $this->getPoster($image->getPosterId())->getUsername();
            if (!isset($poster)) throw new \Exception("Invalid credentials.");
            $imageObj = [
                "id" => $image->getId(),
                "path" => $image->getImagePath(),
                "title" => $image->getImageTitle(),
                "text" => $image->getImageDescription(),
                "postDate" => $image->getUploadDate(),
                "poster" => $poster
            ];
            array_push($imageArray, $imageObj );
        }
        echo json_encode(["hasImages" => true, "Images" => $imageArray]);
    }

    public function deleteImage(int $id, array $userData)
    {
        if ($this->isValidUser($userData))
        {
            if (isset($id))
            {
                $this->imageRepository->deleteImageById($id);
            }
            else throw new \Exception("Invalid data.");
        }
        else throw new \Exception("Invalid credentials.");
    }

    public function editImage(array $imageData, array $userData)
    {
        if ($this->isValidUser($userData))
        {
            if ($this->validateImageData($imageData) && isset($imageData['id']))
            {
                $this->imageRepository->updateImage(new Image($imageData['title'], $imageData['description'], "", "", 0, $userData['userId']), $imageData['id']);
            }
            else throw new \Exception("Invalid data.");
        }
        else throw new \Exception("Invalid credentials.");
    }

    private function isValidUser(array $data)
    {
        if (isset($data['userId']) && isset($data['password'])) {
            $user = $this->userRepository->getUserById($data['userId']);
            if (isset($user))
            {
                if ($this->hasher->MatchPasswords($data['password'], $user->getPassword()) && $user->getRoleId()==3)
                {
                    return true;
                }
                return false;
            }
            return false;
        }

        return false;
    }

    private function validateImageData(array $imageData): bool
    {
        if (isset($imageData['title']) && isset($imageData['description'])) return true;
        return false;
    }

    private function getPoster(int $id)
    {
        return $this->userRepository->getUserById($id);
    }
}