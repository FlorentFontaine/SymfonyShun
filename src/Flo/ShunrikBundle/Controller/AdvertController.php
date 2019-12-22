<?php

// src/Flo/ShunrikBundle/Controller/AdvertController.php

namespace Flo\ShunrikBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Flo\ShunrikBundle\Entity\Voice;
use Flo\ShunrikBundle\Form\VoiceType;
use Flo\ShunrikBundle\Form\VoiceEditType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class AdvertController extends Controller{

  public function indexAction() {
      // Dans l'action indexAction() :
    $em= $this
    ->getDoctrine()
    ->getManager()
    ->getRepository('FloShunrikBundle:Voice')
    ->myFind('Shun')
  ;
    return $this->render('FloShunrikBundle:Advert:index.html.twig', array('listAdverts' => $em ));
    // $request->getSession()->getFlashBag()->add('notice', 'Page pas encore utilisable.');
    // return $this->redirectToRoute('flo_Shunrik_home');
  }

  public function contactAction(request $request) {
    // Dans l'action indexAction() :
      return $this->render('FloShunrikBundle:Advert:contact.html.twig');
  }
  public function serviceAction(request $request) {
    // Dans l'action indexAction() :
      return $this->render('FloShunrikBundle:Advert:service.html.twig');
  }

  public function formAction(request $request) {
    // Dans l'action indexAction() :
      return $this->render('FloShunrikBundle:Advert:formation.html.twig');
  }

  public function compAction(request $request) {
    // Dans l'action indexAction() :
      return $this->render('FloShunrikBundle:Advert:comp.html.twig');
  }

  public function expAction(request $request) {
    // Dans l'action indexAction() :
      return $this->render('FloShunrikBundle:Advert:contact.html.twig');
  }

  public function divAction(request $request) {
    // Dans l'action indexAction() :
      return $this->render('FloShunrikBundle:Advert:div.html.twig');
  }

  public function listVoiceAction() {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $em= $this
    ->getDoctrine()
    ->getManager()
    ->getRepository('FloShunrikBundle:Voice')
    ->myFind('Flo')
  ;
    return $this->render('FloShunrikBundle:Advert:listVoice.html.twig', array('listAdverts' => $em ));
  }


  public function listServiceAction() {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('FloShunrikBundle:Service');
    $listServices =  $repository ->findAll();
    
    return $this->render('FloShunrikBundle:Advert:listReal.html.twig', array('listServices' => $listServices ));
  }

  public function listCvAction() {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('FloShunrikBundle:Cv');
    $listCv =  $repository ->findAll();
    
    return $this->render('FloShunrikBundle:Advert:listReal.html.twig', array('listCv' => $listCv ));
  }

  public function viewAction($id)
  {
    // On récupère le repository
    $em = $this->getDoctrine()->getManager();
    // On récupère l'entité correspondante à l'id $id
    $advert = $em->getRepository('FloShunrikBundle:Voice')->find($id);
    // $advert est donc une instance de flo\floShunrik\Entity\Advert
    // ou null si l'id $id  n'existe pas, d'où ce if :
    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }


    return $this->render('FloShunrikBundle:Advert:view.html.twig', array(
      'voice'           => $advert,
    ));
  }

  public function addAction(Request $request){
    // On crée un objet Advert
    $advert = new Voice();
    $advert->setDate(new \Datetime());
    $form = $this->createForm(VoiceType::class, $advert);

    // Si la requête est en POST
    if ($request->isMethod('POST')) {
      // On fait le lien Requête <-> Formulaire
      // À partir de maintenant, la variable $advert contient les valeurs entrées dans le formulaire par le visiteur
      $form->handleRequest($request);

      // On vérifie que les valeurs entrées sont correctes
      // (Nous verrons la validation des objets en détail dans le prochain chapitre)
      if ($form->isValid()) {
        // On enregistre notre objet $advert dans la base de données, par exemple
        $em = $this->getDoctrine()->getManager();

        $file = $advert->getfilename();
        $filename = md5(uniqid()).'.'.$file->guessExtension();
        
        $file->move($this->getParameter('upload_directory', $filename));
        $advert->setfilename($filename);

        $em->persist($advert);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

        // On redirige vers la page de visualisation de l'annonce nouvellement créée
        return $this->redirectToRoute('flo_shunrik_view', array('id' => $advert->getId()));
      }
    }

    // À ce stade, le formulaire n'est pas valide car :
    // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
    // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau
    return $this->render('FloShunrikBundle:Advert:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }

    
    public function editAction($id, Request $request)
      {
        $em = $this->getDoctrine()->getManager();
    
        $advert = $em->getRepository('FloShunrikBundle:Voice')->find($id);
    
        if (null === $advert) {
          throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }
    
        $form = $this->get('form.factory')->create(VoiceType::class, $advert);
    
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
          // Inutile de persister ici, Doctrine connait déjà notre annonce
          $em->flush();
    
          $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');
    
          return $this->redirectToRoute('flo_shunrik_view', array('id' => $advert->getId()));
        }
    
        return $this->render('FloShunrikBundle:Advert:edit.html.twig', array(
          'advert' => $advert,
          'form'   => $form->createView(),
        ));
      }

  public function deleteAction($id, request $request) {
    $em = $this->getDoctrine()->getManager();
    // On récupère l'annonce $id
    $advert = $em->getRepository('FloShunrikBundle:Voice')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }
    // On déclenche la modification
    
    $form = $this->get('form.factory')->create();

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em->remove($advert);
      $em->flush();
      $request->getSession()->getFlashBag()->add('notice', 'Annonce bien supprimé.');
      return $this->redirectToRoute('flo_shunrik_add');
    }
    // Ici, on récupérera l'annonce correspondant à $id
    // Ici, on gérera la suppression de l'annonce en question
    return $this->render('FloShunrikBundle:Advert:delete.html.twig', array(
      'voice' => $advert,
      'form'   => $form->createView(),
    ));
}
  
  public function menuAction($limit)
  {
    $em = $this->getDoctrine()->getManager();

    $listAdverts = $em->getRepository('FloShunrikBundle:Voice')->findBy(
      array(),                 // Pas de critère
      array('date' => 'desc'), // On trie par date décroissante
      $limit,                  // On sélectionne $limit annonces
      0                        // À partir du premier
    );

    return $this->render('FloShunrikBundle:Advert:menu.html.twig', array(
      'listAdverts' => $listAdverts
    ));
  }

  public function listAction($page)
  {
    if ($page < 1) {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    }

    // Ici je fixe le nombre d'annonces par page à 3
    // Mais bien sûr il faudrait utiliser un paramètre, et y accéder via $this->container->getParameter('nb_per_page')
    $nbPerPage = 3;

    // On récupère notre objet Paginator
    $listAdverts = $this->getDoctrine()
      ->getManager()
      ->getRepository('FloShunrikBundle:Voice')
      ->getAdverts($page, $nbPerPage)
    ;

    // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
    $nbPages = ceil(count($listAdverts) / $nbPerPage);

    // Si la page n'existe pas, on retourne une 404
    if ($page > $nbPages) {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    }

    // On donne toutes les informations nécessaires à la vue
    return $this->render('FloShunrikBundle:Advert:list.html.twig', array(
      'listAdverts' => $listAdverts,
      'nbPages'     => $nbPages,
      'page'        => $page,
    ));
  }
}
