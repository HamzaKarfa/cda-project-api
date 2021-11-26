<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Entity\Image;
use App\Entity\Product;
use App\Repository\SubCategoryRepository;
use DateTime;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\RequestStack;

#[AsController]
class PostProductController extends AbstractController
{
    public function __invoke( Request $request, SluggerInterface $slugger,  SubCategoryRepository $subCategoryRepository)
    {
        $name= $request->request->get('name');
        $origin= $request->request->get('origin');
        $price= $request->request->get('price');
        $subCategoryId= $request->request->get('subCategory');
        $uploadedFile = $request->files->get('image');


        $subCategory = $subCategoryRepository->find($subCategoryId);
        $product = new Product();
        $Image = new Image();
        
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"image" is required');
        }
        $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeFilename = $slugger->slug($originalFilename);
        $newFilename = $safeFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();
        // Move the file to the directory where brochures are stored
        try {
            $uploadedFile->move(
                $this->getParameter('product_directiory'),
                $newFilename
            );
        } catch (FileException $e) {
            // ... handle exception if something happens during file upload
        }

        $Image->setImagePath($newFilename);
        $product->setImage($Image);
        $product->setSubCategory($subCategory);

        $product->setName($name);
        $product->setOrigin($origin);
        $product->setPrice($price);

        $product->setCreatedAt(new DateTime());
        $product->setUpdatedAt(new DateTime());
        return $product;
    }
}