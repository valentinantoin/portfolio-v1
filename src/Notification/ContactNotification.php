<?php

namespace App\Notification;

use App\Entity\Contact;
use Twig\Environment;


/**
 * Class ContactNotification
 * @package App\Notification
 */
class ContactNotification {

    /**
     * ContactNotification constructor.
     * @param \Swift_Mailer $mailer
     * @param Environment $renderer
     */
    public function __construct(\Swift_Mailer $mailer, Environment $renderer) {

        $this->mailer = $mailer;
        $this->renderer = $renderer;

    }


    /**
     * @param Contact $contact
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function notify(Contact $contact) {

        $message = (new \Swift_Message($contact->getSubject()))
            ->setFrom('anva6816@melon.o2switch.net')
            ->setTo('valentin.antoin@gmail.com')
            ->setReplyTo($contact->getMail())
            ->setBody($this->renderer->render('contact/mail.html.twig', [
                'contact' => $contact
            ]), 'text/html');

        $this->mailer->send($message);

    }


}

