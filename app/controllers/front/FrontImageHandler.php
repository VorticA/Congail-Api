<?php
/**
 * Created by PhpStorm.
 * User: viki8
 * Date: 6/24/2019
 * Time: 9:10 AM
 */

namespace App\Controllers\Front;


use App\Controllers\iImageController;

class FrontImageHandler implements iFrontImageHandler
{
    /**
     * @var iImageController
     */
    private $controller;
    /**
     * @var array
     */
    private $post;
    /**
     * @var array
     */
    private $session;
    /**
     * @var array
     */
    private $files;

    public function __construct(iImageController $controller, array $post, array $session, array $files)
    {
        $this->controller = $controller;
        $this->post = $post;
        $this->session = $session;
        $this->files = $files;
    }

    public function galleryHandler()
    {
        $this->controller->getFullGallery();
    }

    public function editHandler()
    {
        $this->controller->editImage($this->post,$this->session);
    }

    public function uploadHandler()
    {
        $this->controller->uploadImage($this->post, $this->files, $this->session);
    }

    public function deleteHandler()
    {
        $this->controller->deleteImage($this->post['id'], $this->session);
    }
}