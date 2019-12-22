<?php

// src/Flo/CoreBundle/Controller/AdvertController.php

namespace Flo\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdvertController extends Controller{

  public function indexAction() {
      // Dans l'action indexAction() :
    return $this->render('FloCoreBundle:advert:index.html.twig');
  }
}