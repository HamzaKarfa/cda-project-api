<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\SubCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Request;
#[AsController]
class PostProductController  extends AbstractController
{
    public function __construct( )
    {
        
    }
    public function __invoke()
    {
    }
}