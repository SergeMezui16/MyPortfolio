<?php

namespace App\Controller;

use App\Form\ContactType;
use Symfony\Component\Mime\Email;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * Home Page
     *
     * @return Response
     */
    #[Route('/', name: 'home')]
    public function index(): Response
    {

        $this->addFlash(
            'info',
            "<strong>Votre Mail a bien été envoyé !</strong>"
        );
        return $this->render('home/index.html.twig', [
            'form' => $this->createForm(ContactType::class)->createView()
        ]);
    }

    /**
     * Send a mail
     *
     * @param Request $request
     * @param MailerInterface $mailer
     * @return RedirectResponse
     */
    #[Route('/mail', name: 'mail')]
    public function sendMail(Request $request, MailerInterface $mailer) : RedirectResponse
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            
            $name = $form->getData()['name'];
            $email = $form->getData()['email'];
            $object = $form->getData()['object'];
            $message = $form->getData()['message'];


            $html = "<!DOCTYPE html><html><head><title>New Message</title></head><body><h1>New Message from : {$name}</h1>
            <p><ul>
                <li>Name : {$name}</li>
                <li>Email : {$email}</li>
                <li>Subject : {$object}</li>
                <li>Message : {$message}</li>
              </ul></p></body></html>";


            $mail = (new Email())
                    ->from('contact@sergemezui.com')
                    ->to('sergemezui2@gmail.com')
                    ->addTo('contact@sergemezui.com')
                    ->subject('New Message From Portfolio')
                    ->html($html);
    
            $mailer->send($mail);

            $this->addFlash(
                'info',
                "<strong>Votre Mail a bien été envoyé !</strong>"
            );
        } else {

            $this->addFlash(
                'danger',
                "Erreur lors de l'envoie du mail :'<strong>{$form->getErrors()->__toString()}</strong> "
            );
        }


        return $this->redirectToRoute('home', ['_fragment' => 'contact']);
    }
}
