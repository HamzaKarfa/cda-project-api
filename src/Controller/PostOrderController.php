<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpFoundation\Request;

#[AsController]
class PostOrderController  extends AbstractController
{
    public function __construct( )
    {
        
    }
    public function __invoke(Request $request)
    {
        return($request);
        // try{
        //     \Stripe\Stripe::setApiKey('sk_test_51H1pgUELWEJ2P8yhcW3i8WyQdJFlx0HeBo4FS5AZcotnzcAR9VJV1PBLV870yK8GvgetgqopG1FKeo7Ei8lbOQA900S8TFpHi5');


        //     $charge = \Stripe\PaymentIntent::create([
        //         'amount' => 100*100,
        //         'currency' => 'eur',
        //         // Verify your integration in this guide by including this parameter
        //         'metadata' => ['integration_check' => 'accept_a_payment'],
        //     ]);
        //     echo 'Merci pour votre participation';
        // }
        // catch(\Exception $e){
        //     dd('erreur payment',$e,$e->getMessage());
        // }

    }
}