<?php

namespace App\Controller;

use DateTime;
use App\Entity\Image;
use App\Entity\Price;
use App\Entity\Product;
use App\Repository\SubCategoryRepository;
use App\Traits\UploadImageTrait;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

#[AsController]
class PostProductController extends AbstractController
{
    use UploadImageTrait;
    public function __invoke( Request $request, SluggerInterface $slugger,  SubCategoryRepository $subCategoryRepository)
    {
        $name= $request->request->get('name');
        $origin= $request->request->get('origin');
        $priceFloat= $request->request->get('price');
        $priceType= $request->request->get('priceType');
        $subCategoryId= $request->request->get('sub_categories');
        $uploadedFile = $request->files->get('image');

        $subCategory = $subCategoryRepository->find($subCategoryId);
        $product = new Product();
        $image = new Image();
        $price = new Price();
        
        if (!$uploadedFile) {
            throw new BadRequestHttpException('"image" is required');
        }
        // See UploadFileTrait
        $newFilename = $this->uploadFiles($uploadedFile, 'product_directory', $slugger);

        $image->setImagePath($request->getSchemeAndHttpHost() . '/uploads/products/' . $newFilename);
        
        $price->setPrice($priceFloat);
        $price->setType($priceType);

        $product->setImage($image);
        $product->setSubCategory($subCategory);
        $product->setName($name);
        $product->setOrigin($origin);
        $product->setPrice($price);
        $product->setCreatedAt(new DateTime());
        $product->setUpdatedAt(new DateTime());
        
        return $product;
    }
}