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

                   // $sql ="SELECT * from Utilisateur WHERE id='+$un+' AND pass ='+$deux";
                    $sql ="SELECT * from user WHERE id='" . $un . "' AND password ='" . $deux ."'";



                    $trois = $dbh->query($sql);
                   //var_dump($trois);
                    //foreach ($trois as $row) {
                       // print $row['id'] . "\t";
                        //print $row['pass'] . "\t";
                        //print $row['message'] . "\n";
                    //}

                    $temp = $trois->rowCount();

                    if($temp!==0){
                           
                        return $this->render('affichage.html.twig', [
                            'message' => 'OUIIIIIIIIII',
                        ]);
    
                    }else{
                        
                        return $this->render('login.html.twig', [
                            'message' => 'Ceci sera la page de login',
                        ]);

                    }


                }

                
                return $this->render('login.html.twig', [
                    'message' => 'Ceci sera la page de login',
                ]);

    }
}
