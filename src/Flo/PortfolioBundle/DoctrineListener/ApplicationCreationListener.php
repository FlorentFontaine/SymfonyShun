<?php
// src/Flo/PortfolioBundle/DoctrineListener/ApplicationCreationListener.php

namespace Flo\PortfolioBundle\DoctrineListener;

use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use Flo\PortfolioBundle\Email\ApplicationMailer;
use Flo\PortfolioBundle\Entity\Application;

class ApplicationCreationListener
{
  /**
   * @var ApplicationMailer
   */
  private $applicationMailer;

  public function __construct(ApplicationMailer $applicationMailer)
  {
    $this->applicationMailer = $applicationMailer;
  }

  public function postPersist(LifecycleEventArgs $args)
  {
    $entity = $args->getObject();

    // On ne veut envoyer un email que pour les entités Application
    if (!$entity instanceof Application) {
      return;
    }

    $this->applicationMailer->sendNewNotification($entity);
  }
}
