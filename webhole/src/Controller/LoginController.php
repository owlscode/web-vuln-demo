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
            

                if(!empty($_POST)){

                    $myusername = $_POST['username'];
                    $mypassword = $_POST['password']; 
                   
               
                    $dbh = new PDO('mysql:host=db;dbname=WebHole', 'root', 'root');

                    $un = $_POST['username'];
                    $deux = $_POST['password'];

                    $sel='chips';
                  
                    $toCheck = $sel . $deux ;


                    $hashedPassword = hash('sha256', $toCheck);
                   //var_dump($hashedPassword);
                    $shaDeux = sha1($deux); 
                    //var_dump($shaDeux);

                    
                    //var_dump($toCheck);

                   // $sql ="SELECT * from Utilisateur WHERE id='+$un+' AND pass ='+$deux";
                    $sql ="SELECT * from user WHERE id='" . $un . "' AND password ='" . $hashedPassword ."'";


                    //************************************************************************* */

                    //$sql2 ="SELECT * from user";

                    //$quer = $dbh->query($sql2);

                    

                    //************************************************************************* */
                    //On affiche les lignes du tableau une à une à l'aide d'une boucle
                   
                        

                    $trois = $dbh->query($sql);
                   var_dump($trois);

                   $tableau = array() ;
                   
                    foreach ($trois as $row) {

                        $tableau[]=$row;
                        
                        // $id = $row['id'];
                        // $password = $row['password'];
                        // $creditCardNumber = $row['creditCardNumber'];
                        // $role = $row['role'];
                        // $firstname = $row['firstname'];


                       
                    }


                   // print $id;

                    $temp = $trois->rowCount();
                    //var_dump($temp);

                    if($temp!==0){
                           
                        return $this->render('display.html.twig', [
                            'tableau' => $tableau,

                        ]);
                        //var_dump($essai);
    
                    }

                    


                }

                
                return $this->render('login.html.twig', [
                    'message' => 'Ceci sera la page de login',
                ]);

    }
}
