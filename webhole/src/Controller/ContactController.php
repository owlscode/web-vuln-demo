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
            $task = $form->getData();

            $file = $form['file']->getData();
            if ($file) {
                $originalFilename = $file->getClientOriginalName();
                $newFilePath = 'uploads/' . md5($originalFilename . time()) . '/';

                try {
                    $file->move(
                        $newFilePath,
                        $originalFilename,
                    );
                } catch (FileException $e) {

                }

            }

        }

        return $this->render('contact.html.twig', [
            'test' => 'this is a test',
            'form' => $form->createView(),
        ]);      
    }
   
}