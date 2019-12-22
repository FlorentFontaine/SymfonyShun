<?php

// src/Flo/PortfolioBundle/Controller/AdvertController.php

namespace Flo\PortfolioBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Flo\PortfolioBundle\Entity\Advert;
use Flo\PortfolioBundle\Entity\Image;
use Flo\PortfolioBundle\Entity\Application;
use Flo\PortfolioBundle\Entity\AdvertSkill;
use Flo\PortfolioBundle\Form\AdvertType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class AdvertController extends Controller{

  public function indexAction($page) {
      // Dans l'action indexAction() :
    return $this->render('FloPortfolioBundle:Advert:index.html.twig');
    // $request->getSession()->getFlashBag()->add('notice', 'Page pas encore utilisable.');
    // return $this->redirectToRoute('flo_portfolio_home');
  }

  public function contactAction(request $request) {
    // Dans l'action indexAction() :
      return $this->render('FloPortfolioBundle:Advert:contact.html.twig');
  }
  public function serviceAction(request $request) {
    // Dans l'action indexAction() :
      return $this->render('FloPortfolioBundle:Advert:service.html.twig');
  }

  public function formAction(request $request) {
    // Dans l'action indexAction() :
      return $this->render('FloPortfolioBundle:Advert:formation.html.twig');
  }

  public function compAction(request $request) {
    // Dans l'action indexAction() :
      return $this->render('FloPortfolioBundle:Advert:comp.html.twig');
  }

  public function expAction(request $request) {
    // Dans l'action indexAction() :
      return $this->render('FloPortfolioBundle:Advert:contact.html.twig');
  }

  public function divAction(request $request) {
    // Dans l'action indexAction() :
      return $this->render('FloPortfolioBundle:Advert:div.html.twig');
  }

  public function listRealAction() {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $em= $this
    ->getDoctrine()
    ->getManager()
    ->getRepository('FloPortfolioBundle:Advert')
    ->myFind('Florent')
  ;
    return $this->render('FloPortfolioBundle:Advert:listReal.html.twig', array('listAdverts' => $em ));
  }
  public function listServiceAction() {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('FloPortfolioBundle:Service');
    $listServices =  $repository ->findAll();
    
    return $this->render('FloPortfolioBundle:Advert:listReal.html.twig', array('listServices' => $listServices ));
  }

  public function listCvAction() {
    // On fixe en dur une liste ici, bien entendu par la suite
    // on la récupérera depuis la BDD !
    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('FloPortfolioBundle:Cv');
    $listCv =  $repository ->findAll();
    
    return $this->render('FloPortfolioBundle:Advert:listReal.html.twig', array('listCv' => $listCv ));
  }

  public function viewAction($id)
  {
    // On récupère le repository
    $em = $this->getDoctrine()->getManager();
    // On récupère l'entité correspondante à l'id $id
    $advert = $em->getRepository('FloPortfolioBundle:Advert')->find($id);
    // $advert est donc une instance de flo\floportfolio\Entity\Advert
    // ou null si l'id $id  n'existe pas, d'où ce if :
    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    $listApplications = $em->getRepository('FloPortfolioBundle:Application')->findBy(array('advert' => $advert));
    $listAdvertSkills = $em->getRepository('FloPortfolioBundle:AdvertSkill')->findBy(array('advert' => $advert));

    return $this->render('FloPortfolioBundle:Advert:view.html.twig', array(
      'advert'           => $advert,
      'listApplications' => $listApplications,
      'listApplications' => $listAdvertSkills,
    ));
  }

  public function addAction(Request $request){
    // On crée un objet Advert
    $advert = new Advert();
    $advert->setDate(new \Datetime());
    $form = $this->createForm(AdvertType::class, $advert);

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
        $em->persist($advert);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

        // On redirige vers la page de visualisation de l'annonce nouvellement créée
        return $this->redirectToRoute('flo_portfolio_view', array('id' => $advert->getId()));
      }
    }

    // À ce stade, le formulaire n'est pas valide car :
    // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
    // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau
    return $this->render('FloPortfolioBundle:Advert:add.html.twig', array(
      'form' => $form->createView(),
    ));
  }

  

  public function editAction($id, Request $request) {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $advert = $em->getRepository('FloPortfolioBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }
    $form = $this->get('form.factory')->create(AdvertType::class, $advert);

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
        $em->persist($advert);
        $em->flush();

        $request->getSession()->getFlashBag()->add('notice', 'Annonce bien enregistrée.');

        // On redirige vers la page de visualisation de l'annonce nouvellement créée
        return $this->redirectToRoute('flo_portfolio_view', array('id' => $advert->getId()));
      }
    }

    // Si on n'est pas en POST, alors on affiche le formulaire
    return $this->render('FloPortfolioBundle:Advert:edit.html.twig', array('advert' => $advert, 'form' => $form->createView(),));
    }
  

  public function deleteAction($id, request $request) {
    $em = $this->getDoctrine()->getManager();

    // On récupère l'annonce $id
    $advert = $em->getRepository('FloPortfolioBundle:Advert')->find($id);

    if (null === $advert) {
      throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
    }

    // On boucle sur les catégories de l'annonce pour les supprimer
    foreach ($advert->getCategories() as $category) {
      $advert->removeCategory($category);
    }
    // On déclenche la modification
    $em->flush();
    $request->getSession()->getFlashBag()->add('notice', 'Annonce bien supprimé.');
    // Ici, on récupérera l'annonce correspondant à $id
    // Ici, on gérera la suppression de l'annonce en question
    return $this->render('FloPortfolioBundle:Advert:delete.html.twig', array(
      'advert' => $advert
    ));
  }
  
  public function menuAction($limit)
  {
    $em = $this->getDoctrine()->getManager();

    $listAdverts = $em->getRepository('FloPortfolioBundle:Advert')->findBy(
      array(),                 // Pas de critère
      array('date' => 'desc'), // On trie par date décroissante
      $limit,                  // On sélectionne $limit annonces
      0                        // À partir du premier
    );

    return $this->render('FloPortfolioBundle:Advert:menu.html.twig', array(
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
      ->getRepository('FloPortfolioBundle:Advert')
      ->getAdverts($page, $nbPerPage)
    ;

    // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
    $nbPages = ceil(count($listAdverts) / $nbPerPage);

    // Si la page n'existe pas, on retourne une 404
    if ($page > $nbPages) {
      throw $this->createNotFoundException("La page ".$page." n'existe pas.");
    }

    // On donne toutes les informations nécessaires à la vue
    return $this->render('FloPortfolioBundle:Advert:list.html.twig', array(
      'listAdverts' => $listAdverts,
      'nbPages'     => $nbPages,
      'page'        => $page,
    ));
  }
}
