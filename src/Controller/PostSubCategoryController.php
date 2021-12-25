<?php

namespace App\Controller;

use DateTime;
use App\Entity\Image;
use App\Entity\SubCategory;
use App\Repository\CategoryRepository;
use App\Traits\UploadImageTrait;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[AsController]
class PostSubCategoryController extends AbstractController
{
    use UploadImageTrait;
    public function __invoke( Request $request, SluggerInterface $slugger,  CategoryRepository $categoryRepository)
    {
        $name= $request->request->get('name');
        $categoryId= $request->request->get('categories');
        $uploadedFile = $request->files->get('image');

        $category = $categoryRepository->find($categoryId);
        $subCategory = new SubCategory();
        $image = new Image();
        
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"image" is required');
        }

        // See UploadFileTrait
        $newFilename = $this->uploadFiles($uploadedFile, 'sub_categories_directory', $slugger);

        $image->setImagePath($request->getSchemeAndHttpHost() . '/uploads/sub_categories/' . $newFilename);
        $subCategory->setImage($image);
        $subCategory->setCategory($category);

        $subCategory->setName($name);
        return $subCategory;
    }
}