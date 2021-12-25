<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProductCategoryFixtures extends Fixture
{

    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $categoriesNames = ['Fruits et légumes', 'Epicerie d’ici et d’ailleurs', 'Fromagerie', 'Boucherie', 'Poissonnerie'];
        $categoriesDescriptions = ["ON DONNE LA PRIMEUR AU GOÛT", "LES SAVEURS D'ICI SE MARIENT À CELLES D'AILLEURS", "LA CRÈME DES FROMAGES EST SERVIE SUR UN PLATEAU", "ON SAIT TOUT DE LA VIANDE QU'ON ACHÈTE", "LA FRAÎCHEUR DÉBARQUE SUR VOS ÉTALS"];
        $categoriesImages = ['FL.jpg', "EP.jpg", "FROM.jpg", "BOU.jpg", "POISS.jpg"];
        foreach ($categoriesNames as $key=> $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $category->setDescription($categoriesDescriptions[$key]);
            $category->setImage($categoriesImages[$key]);
            $manager->persist($category);
        }
        $manager->flush();
    }

    public function contact(Request $request): Response
    {
        $defaultData = ['message' => 'Type your message here'];
        $form = $this->createFormBuilder($defaultData)
            ->add('nom', TextType::class)
            ->add('prenom', TextType::class)
            ->add('email', EmailType::class)
            ->add('message', TextareaType::class)
            ->add('send', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // data is an array with "name", "email", and "message" keys
            $data = $form->getData();
            $email = (new TemplatedEmail())
            ->from(new Address('basilesimplon@gmail.com', 'Basile Mail Bot'))
            ->to('basilesimplon@gmail.com')
            ->subject('Demande de devis')
            ->htmlTemplate('devis/email.html.twig')
            ->context([
                'nom' => $data['nom'],
                'prenom' => $data['prenom'],
                'email' => $data['email'],
                'message' => $data['message'],
            ]);

            $mailer->send($email);

        }
        

        // ... render the form
    }
}

