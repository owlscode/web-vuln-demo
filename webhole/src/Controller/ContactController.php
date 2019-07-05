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
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $task = $form->getData();

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($task);
            // $entityManager->flush();

            $file = $form['file']->getData();
            if ($file) {
                $originalFilename = $file->getClientOriginalName();
                $newFilePath = 'uploads/' . md5($originalFilename . time()) . '/';

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

            //return $this->redirectToRoute('task_success');
        }

        return $this->render('contact.html.twig', [
            'test' => 'pas post',
            'form' => $form->createView(),
        ]);
    }

}