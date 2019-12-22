<?php
// src/Flo/PortfolioBundle/Email/ApplicationMailer.php

namespace Flo\PortfolioBundle\Email;

use Flo\PortfolioBundle\Entity\Application;

class ApplicationMailer
{
  /**
   * @var \Swift_Mailer
   */
  private $mailer;

  public function __construct(\Swift_Mailer $mailer)
  {
    $this->mailer = $mailer;
  }

  public function sendNewNotification(Application $application)
  {
    $message = new \Swift_Message(
      'Nouvelle candidature',
      'Vous avez reçu une nouvelle candidature.'
    );

    $message
      ->addTo($application->getAdvert()->getMail()) // Ici bien sûr il faudrait un attribut "email", j'utilise "author" à la place
      ->addFrom('florent_fontaine@hotmail.com')
    ;

    $this->mailer->send($message);
  }
}
