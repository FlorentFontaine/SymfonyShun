<?php
// src/Flo/ShunrikBundle/Entity/VoiceRepository.php

namespace Flo\ShunrikBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;

class VoiceRepository extends EntityRepository
{
    public function myFindOne($id){
        $qb = $this->createQueryBuilder('a');

        $qb ->where('a.id = :id')
            ->setParameter('id', $id);

        return $qb  ->getQuery()
                    ->getResult();
    }

    public function whereCurrentYear(QueryBuilder $qb)
  {
    $qb
      ->andWhere('a.date BETWEEN :start AND :end')
      ->setParameter('start', new \Datetime(date('Y').'-01-01'))  // Date entre le 1er janvier de cette année
      ->setParameter('end',   new \Datetime(date('Y').'-12-31'))  // Et le 31 décembre de cette année
    ;
  }

    public function myFind($title){
        $qb = $this->createQueryBuilder('a');

        // On peut ajouter ce qu'on veut avant
        $qb
        ->where('a.title = :title')
        ->setParameter('title', $title)
        ->setMaxResults(5);
      ;
        return $qb
            ->getQuery()
            ->getResult();
    }

    public function getAdvertWithApplications(){
        $qb = $this
            ->createQueryBuilder('a')
            ->leftJoin('a.applications', 'app')
            ->addSelect('app')
        ;

        return $qb
            ->getQuery()
            ->getResult()
        ;
    }

        
    public function getAdvertWithCategories(array $categoryNames){
        $qb = $this
            ->createQueryBuilder('a')
            ->innerJoin('a.category' , 'cat')
            ->addSelect('cat');

        $qb->where($qb->expr()->in('c.name', $categoryNames));
            
            return $qb
                ->getQuery()
                ->getResult();
    }

        public function getAdverts($page, $nbPerPage)
        {
          $query = $this->createQueryBuilder('a')
            ->leftJoin('a.image', 'i')
            ->addSelect('i')
            ->leftJoin('a.categories', 'c')
            ->addSelect('c')
            ->orderBy('a.date', 'DESC')
            ->getQuery()
          ;
      
          $query
            // On définit l'annonce à partir de laquelle commencer la liste
            ->setFirstResult(($page-1) * $nbPerPage)
            // Ainsi que le nombre d'annonce à afficher sur une page
            ->setMaxResults($nbPerPage)
          ;
      
          // Enfin, on retourne l'objet Paginator correspondant à la requête construite
          // (n'oubliez pas le use correspondant en début de fichier)
          return new Paginator($query, true);
        }
}