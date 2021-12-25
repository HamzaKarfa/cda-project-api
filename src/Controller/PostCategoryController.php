<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Image;
use App\Traits\UploadImageTrait;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[AsController]
class PostCategoryController extends AbstractController
{
    use UploadImageTrait;
    public function __invoke( Request $request, SluggerInterface $slugger)
    {
        $name= $request->request->get('name');
        $description= $request->request->get('description');
        $uploadedFile = $request->files->get('image');


        $category = new Category();
        $image = new Image();
        
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"image" is required');
        }

        // See UploadFileTrait
        $newFilename = $this->uploadFiles($uploadedFile, 'categories_directory', $slugger);

        $image->setImagePath($request->getSchemeAndHttpHost() . '/uploads/categories/' . $newFilename);
        $category->setName($name);
        $category->setDescription($description);
        $category->setImage($image);

        return $category;
    }
}