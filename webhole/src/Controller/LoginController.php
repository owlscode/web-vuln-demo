<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \PDO;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginController extends AbstractController
{
    /**
     * @Route("/login")
     */
    public function essai()
    {
        if (!empty($_POST)) {
            //connection à la bdd
            $dbh = new PDO('mysql:host=db;dbname=WebHole', 'root', 'root');

            $un = $_POST['username'];
            $deux = $_POST['password'];
            $sel = 'chips';
            $toCheck = $sel . $deux;
            $hashedPassword = hash('sha256', $toCheck);

            $sql = "SELECT * from user WHERE id='" . $un . "' AND password ='" . $hashedPassword . "'";

            //initialisation de la query
            $trois = $dbh->query($sql);
            $tableau = array();

            foreach ($trois as $row) {

                $tableau[] = $row;              
            }
            $temp = $trois->rowCount();
            if ($temp == 0){
                return $this->render('login.html.twig', [
                    'message' => 'Please Login',
                    'ref' => ''
                ]);
            }
            //sérialisation du tableau avec toutes les infos sur le user
            $tableauSerialize = serialize($tableau[0]);
            //encodage en base 64
            $tab64 = base64_encode($tableauSerialize);

            

            if ($_POST['ref'] === '/registration') {

                //$response = new Response($this->redirectToRoute('registration'));
                $response = new RedirectResponse($this->generateUrl('registration'));
                //création du cookie administrateur/user
                $response->headers->setCookie(Cookie::create("rank", $tab64));
                return $response;
            } elseif ($_POST['ref'] !== '/registration') {
                $response = new Response($this->renderView('displayLogin.html.twig', [
                    'tableau' => $tableau,
                ]));
                //création du cookie administrateur/user
                $response->headers->setCookie(Cookie::create("rank", $tab64));
                return $response;
            } 

            return $this->render('login.html.twig', [
                 'message' => 'Please Login',
                  'ref' => ''
            ]);
            
        }

        if (!isset($_GET['ref'])) {
            return $this->render('login.html.twig', [
                'message' => 'Please Login',
                'ref' => ''
            ]);
        }

        return $this->render('login.html.twig', [
            'message' => 'Please Login',
            'ref' => $_GET['ref']
        ]);
    }
}