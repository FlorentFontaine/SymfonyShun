<?php
// src/Flo/PortfolioBundle/DataFixtures/ORM/LoadSkill.php

namespace Flo\PortfolioBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Flo\PortfolioBundle\Entity\Skill;

class LoadSkill implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    // Liste des noms de compétences à ajouter
    $names = array('PHP', 'Symfony', 'C++', 'Java', 'Photoshop', 'Blender', 'Bloc-note');

    foreach ($names as $name) {
      // On crée la compétence
      $skill = new Skill();
      $skill->setName($name);

      // On la persiste
      $manager->persist($skill);
    }

    // On déclenche l'enregistrement de toutes les catégories
    $manager->flush();
  }
}