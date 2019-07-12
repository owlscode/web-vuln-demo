<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Response;

class LogoutController extends AbstractController
{

    
    /**
     * @Route("/logout")
     */
    public function index()
    {

        $session = new Session();
        // $session->start();
        $session->invalidate();
      
        $response = new Response($this ->render('logout.html.twig', [
            'message' => 'DISCONNECTED',

        ]));
        $response->headers->clearCookie('rank');
        
       
        
        return $response;



      
        
    }
}
