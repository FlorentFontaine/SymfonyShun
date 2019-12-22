<?php

namespace Flo\PortfolioBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Cv
 *
 * @ORM\Table(name="Cv")
 * @ORM\Entity(repositoryClass="Flo\PortfolioBundle\Entity\CvRepository")
 */
class Cv
{
   
    /**
   * @ORM\ManyToOne(targetEntity="Flo\PortfolioBundle\Entity\Cv_section", inversedBy="cv")
   * @ORM\JoinColumn(nullable=false)
   */
  private $cv_section;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=255)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content; 
    
    
  public function __construct()
  {
    $this->date = new \Datetime();
  }



    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set date.
     *
     * @param \DateTime $date
     *
     * @return Cv
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return Cv
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author.
     *
     * @param string $author
     *
     * @return Cv
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author.
     *
     * @return string
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set content.
     *
     * @param string $content
     *
     * @return Cv
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content.
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Add cvSection.
     *
     * @param \Flo\PortfolioBundle\Entity\Cv_section $cvSection
     *
     * @return Cv
     */
    public function addCvSection(\Flo\PortfolioBundle\Entity\Cv_section $cvSection)
    {
        $this->cv_section[] = $cvSection;

        return $this;
    }

    /**
     * Remove cvSection.
     *
     * @param \Flo\PortfolioBundle\Entity\Cv_section $cvSection
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeCvSection(\Flo\PortfolioBundle\Entity\Cv_section $cvSection)
    {
        return $this->cv_section->removeElement($cvSection);
    }

    /**
     * Get cvSection.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCvSection()
    {
        return $this->cv_section;
    }
}
