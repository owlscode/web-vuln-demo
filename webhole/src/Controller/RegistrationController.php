<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \PDO;


class RegistrationController extends AbstractController
{
    /**
     * @Route("/registration")
     */
    public function registrationFonction()
    {

        if (isset($_SESSION['username']) && isset($_SESSION['password'])) {

            $recuperationCookie = $_COOKIE["rank"];

            //decode la base 64

            $decodage64 = base64_decode($recuperationCookie);

            // //deserialization

            $deserializationCookie = unserialize($decodage64);

            $reucpDeLaBonneValeur = $deserializationCookie[0]["role"];

                if($reucpDeLaBonneValeur==="admin"){

                // $tabDeserialize = unserialize($recuperationCookie);
                // $recupValRank = $tabDeserialize[0]["role"];
                // var_dump($recupValRank);

                        if(!empty($_POST)){

                            $registrationId = $_POST['id'];
                            $registrationPassword = $_POST['password'];
                            $registrationCreditCardNumber = $_POST['creditCardNumber'];
                            $registrationRole = $_POST['role'];
                            $registrationFirstName = $_POST['firstname'];


                            $dbhRegistration = new PDO('mysql:host=db;dbname=WebHole', 'root', 'root');

                            $sel='chips';    
                            $toCheck = $sel . $registrationPassword ;
                            $hashedPassword = hash('sha256', $toCheck);


                                
                                $stmt = "INSERT INTO user (id, password, creditCardNumber, role, firstname) VALUES ('$registrationId', '$hashedPassword', '$registrationCreditCardNumber', '$registrationRole', '$registrationFirstName')";
                                
                                $dbhRegistration ->exec($stmt);

                                var_dump($dbhRegistration);
                                
                                return $this->render('displayRegistration.html.twig', [
                                    'message' => 'Registration',
                                ]);

                        }else{
                            return $this->render('registration.html.twig', [
                                'message' => 'Registration',
                            ]);
                        }
                }
                return $this->render('echecRegistration.html.twig', [
                    'message' => 'Register',
                ]);
        }
        return $this->render('echecRegistration.html.twig', [
            'message' => 'Register',
        ]);


    }//fin de la fonction
}
