<?php
// src/Controller/LuckyController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use \PDO;


class ContactController extends AbstractController
{   
    /**
     * @Route("/contact")
     */
    public function contact(Request $request)
    {

        $form = $this->createFormBuilder()
            ->add('email', EmailType::class)
            ->add('subject', ChoiceType::class, [
                'choices' => [
                    'Problème de connexion' => 'connection',
                    'Perte de mot de passe' => 'password',
                    'Autre' => 'other',
                ],
            ])
            ->add('message', TextareaType::class)
            ->add('file', FileType::class, [
                'label' => "Capture d'écran",
                'required' => false
            ])
            ->add('submit', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $data = $form->getData();
            $requestId = md5($data['email'] . time());
            
            
            $file = $form['file']->getData();
            if ($file) {
                $originalFilename = $file->getClientOriginalName();
                $newFilePath = 'uploads/' . $requestId . '/';
                
                // Move the file to the directory where brochures are stored
                try {
                    $file->move(
                        $newFilePath,
                        $originalFilename,
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }
                
            }
            
            $u = (isset($_COOKIE['rank'])) ? unserialize(base64_decode($_COOKIE['rank']))['id'] : "";
            $f = $originalFilename ?? "";
            
            try {
                $db = new PDO('mysql:host=db;dbname=WebHole', 'root', 'root');
                $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $db->prepare("INSERT INTO support VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->bindParam(1, $requestId);
                $stmt->bindParam(2, $u); // if id is set in $_COOKIE
                $stmt->bindParam(3, $data['email']);
                $stmt->bindParam(4, $data['subject']);
                $stmt->bindParam(5, $data['message']);
                $stmt->bindParam(6, $f);

                $stmt->execute();
            } catch (Exception $e) {
                print "tott";
            }
            
            return $this->render('contact/preview.html.twig', [
                'link' => '/contact/' . $requestId,
            ]);
        }

        return $this->render('contact/send.html.twig', [
            'form' => $form->createView(),
        ]);      
    }
   
    /**
     * @Route("/contact/{id}", requirements={"id"="[a-f0-9]{32}"})
     */
    public function view($id) {
        try {

            $db = new PDO('mysql:host=db;dbname=WebHole', 'root', 'root');
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
            $stmt = $db->prepare("SELECT * FROM support WHERE id = ?");
            $stmt->execute(array($id));
            
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            var_dump($rows);
        } catch (PDOException $e) {
            print "ttojzgfns";
        }

        if (sizeof($rows) != 1) {
            throw $this->createNotFoundException('The page does not exist.');
        }

        return $this->render('contact/view.html.twig', [
            'request' => $rows[0]
        ]);
    }
}