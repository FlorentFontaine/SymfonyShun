<?php
// src/flo/PortfolioBundle/Entity/service.php

namespace Flo\PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="Flo\PortfolioBundle\Entity\ServiceRepository")
 */
class Service
{
        /**
   * @ORM\OneToOne(targetEntity="Flo\PortfolioBundle\Entity\Image", cascade={"persist"})
   */
  private $image;

  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;
    
  /**
   * @ORM\Column(name="title", type="string", length=255)
   */
  private $title;

  /**
   * @ORM\Column(name="author", type="string", length=255)
   */
  private $author;

  /**
   * @ORM\Column(name="content", type="text")
   */
  private $content;
  

  /**
   * @ORM\Column(name="date", type="datetime")
   */
  private $date;
  
  public function __construct()
  {
    $this->date = new \Datetime();
  }

  public function getId()
  {
    return $this->id;
  }

  public function setAuthor($author)
  {
    $this->author = $author;

    return $this;
  }

  public function getAuthor()
  {
    return $this->author;
  }

  public function setContent($content)
  {
    $this->content = $content;

    return $this;
  }

  public function getContent()
  {
    return $this->content;
  }

  public function setDate(\Datetime $date)
  {
    $this->date = $date;

    return $this;
  }

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

  public function getDate()
  {
    return $this->date;
  }

    public function setImage(Image $image = null)
    {
      $this->image = $image;
    }
  
    public function getImage()
    {
      return $this->image;
    }

}
