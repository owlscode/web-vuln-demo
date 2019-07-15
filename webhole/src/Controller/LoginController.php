<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use \PDO;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\RedirectResponse;



use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;




class LoginController extends AbstractController
{
    /**
     * @Route("/login")
     */
    public function essai(){

        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);


        if (isset($_GET['ref'])) {

            return $this->render('registration.html.twig', [
                                'message' => 'Please Login',

             ]);
        } 
        
            

                if(!empty($_POST)){
                   

               
                    $dbh = new PDO('mysql:host=db;dbname=WebHole', 'root', 'root');

                    $un = $_POST['username'];
                    $deux = $_POST['password'];

                    $sel='chips';
                  
                    $toCheck = $sel . $deux ;


                    $hashedPassword = hash('sha256', $toCheck);
                   //var_dump($hashedPassword);

                    $sql ="SELECT * from user WHERE id='" . $un . "' AND password ='" . $hashedPassword ."'";

                    // $session = new Session();
                    // $session->start();
                    
                    // on enregistre les paramètres de notre visiteur comme variables de session ($login et $pwd) (notez bien que l'on utilise pas le $ pour enregistrer ces variables)
                    $_SESSION['username'] = $_POST['username'];
                    $_SESSION['password'] = $_POST['password'];

                   

                   

                    // on redirige notre visiteur vers une page de notre section membre
                    

                    $trois = $dbh->query($sql);
                   //var_dump($trois);

                   $tableau = array() ;
                   
                    foreach ($trois as $row) {

                        $tableau[]=$row;
                        
                        // $id = $row['id'];
                        // $password = $row['password'];
                        // $creditCardNumber = $row['creditCardNumber'];
                        // $role = $row['role'];
                        // $firstname = $row['firstname'];                      
                    }

                    //sérialisation du tableau avec toutes les infos sur le user
                    

                    $tableauSerialize = serialize($tableau);

                    // var_dump($tableauSerialize);

                    //desérialization du tableau
                    //$tableauDeserialize = unserialize($tableauSerialize);
                   
                    $tab64 = base64_encode ($tableauSerialize);
                   // var_dump($tab64);

                    //var_dump($tableauDeserialize);

                    //recupération d'une valeur dans ce tableau deserialize

                    //var_dump($tableauDeserialize[0]['role']);

                    // $leRole = $tableauDeserialize[0]['role'];
                    // if($leRole==='admin'){
                    //     var_dump("OK");
                    // }else{
                    //     var_dump("FAUX");
                    // }



                   

                    


                   

                    $temp = $trois->rowCount();

                   
                    
                    
                    if ($temp!==0)
                        {
                        
                       
                        //$redirection = new RedirectResponse($this->monRouteur->generate('displayLogin.html.twig'));
                           
                        $response = new Response($this ->render('displayLogin.html.twig', [
                            'tableau' => $tableau,

                        ]));

                        $response -> headers ->setCookie(Cookie::create("rank",$tab64)); 

                       
                        //var_dump($_COOKIE);
                        //$a = unserialize($_COOKIE["rank"]);
                        //var_dump($a);
                        
                        
                        
                        return $response;


                    
                    }                  

                }


              
                return $this->render('login.html.twig', [
                    'message' => 'Please Login',
                ]);

    }
}
