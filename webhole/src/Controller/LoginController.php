<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \PDO;



class LoginController extends AbstractController
{
    /**
     * @Route("/login")
     */
    public function essai(){
            
                var_dump($_POST);

                if(!empty($_POST)){

                    $hostname = "localhost";
                    $database = "basDeDonnee";
                    $username = "root";
                    $password = "root";
               
                    $dbh = new PDO('mysql:host=localhost;dbname=basDeDonnee', $username, $password);
                    foreach($dbh->query('SELECT * from Utilisateur') as $row) {
                        print_r($row);
                    }

                    if($_POST['username']=='aaa' && $_POST['password']=='bbb'){

                        return $this->render('affichage.html.twig', [
                            'message' => 'OUIIIIIIIIII',
                        ]);
    
                    }


                }

                
                return $this->render('login.html.twig', [
                    'message' => 'Ceci sera la page de login',
                ]);

    }
}
