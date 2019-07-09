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

                    $shaDeux = sha1($deux);

                   // $sql ="SELECT * from Utilisateur WHERE id='+$un+' AND pass ='+$deux";
                    $sql ="SELECT * from user WHERE id='" . $un . "' AND password ='" . $shaDeux ."'";


                    $trois = $dbh->query($sql);
                   var_dump($trois);
                    foreach ($trois as $row) {

                        
                        $id = $row['id'];
                        $password = $row['password'];
                        $creditCardNumber = $row['creditCardNumber'];
                        $role = $row['role'];
                        $firstname = $row['firstname'];


                        print $row['id'] . "\t";
                        print $row['password'] . "\t";
                        print $row['creditCardNumber'] . "\n";
                        print $row['role'] . "\n";
                        print $row['firstname'] . "\n";
                    }


                   // print $id;

                    $temp = $trois->rowCount();

                    if($temp!==0){
                           
                        return $this->render('display.html.twig', [
                            'id' => "$id",
                            'password' => "$password",
                            'creditCardNumber' => "$creditCardNumber",
                            'role' => "$role",
                            'firstname' => "$firstname",

                        ]);
    
                    }


                }

                
                return $this->render('login.html.twig', [
                    'message' => 'Ceci sera la page de login',
                ]);

    }
}
