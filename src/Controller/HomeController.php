<?php

namespace App\Controller;

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
        return $this->render('home/index.html.twig', [

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

        if(
            isset($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message']) &&
            !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['subject']) && !empty($_POST['message'])
        )
        {
            $email = $request->request->get('email');    
            $subject = $request->request->get('subject');  
            $message = $request->request->get('message');

            $mail = (new Email())
                    ->from($email)
                    ->to('sergemzui2@gmail.com')
                    ->subject($subject)
                    ->text($message);
    
            $mailer->send($mail);
        }

        return $this->redirectToRoute('home');
    }
}
