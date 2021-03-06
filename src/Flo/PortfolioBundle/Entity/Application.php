<?php
// src/flo/PortfolioBundle/Entity/Application.php

namespace Flo\PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="application")
 * @ORM\Entity(repositoryClass="Flo\PortfolioBundle\Entity\ApplicationRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Application
{
    /**
   * @ORM\ManyToOne(targetEntity="Flo\PortfolioBundle\Entity\Advert", inversedBy="applications")
   * @ORM\JoinColumn(nullable=false)
   */
  private $advert;

  /**
   * @ORM\Column(name="id", type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

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
  
   /**
   * @ORM\Column(name="mail",  type="string", length=255)
   */
  private $mail;

  public function __construct()
  {
    $this->date = new \Datetime();
  }

    /**
   * @ORM\PrePersist
   */
  public function increase()
  {
    $this->getAdvert()->increaseApplication();
  }

  /**
   * @ORM\PreRemove
   */
  public function decrease()
  {
    $this->getAdvert()->decreaseApplication();
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

  public function setMail($mail)
  {
    $this->mail = $mail;

    return $this;
  }

  public function getMail()
  {
    return $this->mail;
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

  public function getDate()
  {
    return $this->date;
  }

    /**
     * Set advert
     *
     * @param \Flo\PortfolioBundle\Entity\Advert $advert
     *
     * @return Application
     */
    public function setAdvert(\Flo\PortfolioBundle\Entity\Advert $advert)
    {
        $this->advert = $advert;

        return $this;
    }

    /**
     * Get advert
     *
     * @return \Flo\PortfolioBundle\Entity\Advert
     */
    public function getAdvert()
    {
        return $this->advert;
    }
}
