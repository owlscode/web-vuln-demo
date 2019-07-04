<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact")
     */
    public function contact()
    {
        return $this->render('contact.html.twig', [
            'message' => 'Support',
            ]);


    }


    /**
     * @Route("/contact)
     */
}