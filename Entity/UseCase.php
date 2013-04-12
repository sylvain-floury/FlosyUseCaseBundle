<?php

namespace Flosy\Bundle\UseCaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * Flosy\Bundle\UseCaseBundle\Entity\UseCase
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class UseCase
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $aim
     *
     * @ORM\Column(name="aim", type="string", length=500)
     */
    private $aim;

    /**
     * @var string $precondition
     *
     * @ORM\Column(name="precondition", type="string", length=500)
     */
    private $precondition;
    
    /**
     * @ORM\ManyToOne(targetEntity="Project", inversedBy="useCases")
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     **/
    private $project;
    
    /**
     * @ORM\ManyToMany(targetEntity="Actor", mappedBy="useCases")
     */
    protected $actors;
    
    /**
     *
     * @ORM\OneToMany(targetEntity="Scenario", mappedBy="useCase") 
     */
    protected $scenarii;

    public function __construct() {
        $this->scenarii = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return UseCase
     */
    public function setTitle($title)
    {
        $this->title = $title;
    
        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set aim
     *
     * @param string $aim
     * @return UseCase
     */
    public function setAim($aim)
    {
        $this->aim = $aim;
    
        return $this;
    }

    /**
     * Get aim
     *
     * @return string 
     */
    public function getAim()
    {
        return $this->aim;
    }

    /**
     * Set precondition
     *
     * @param string $precondition
     * @return UseCase
     */
    public function setPrecondition($precondition)
    {
        $this->precondition = $precondition;
    
        return $this;
    }

    /**
     * Get precondition
     *
     * @return string 
     */
    public function getPrecondition()
    {
        return $this->precondition;
    }

    /**
     * Add scenarii
     *
     * @param Flosy\Bundle\UseCaseBundle\Entity\Scenario $scenarii
     * @return UseCase
     */
    public function addScenarii(\Flosy\Bundle\UseCaseBundle\Entity\Scenario $scenarii)
    {
        $this->scenarii[] = $scenarii;
    
        return $this;
    }

    /**
     * Remove scenarii
     *
     * @param Flosy\Bundle\UseCaseBundle\Entity\Scenario $scenarii
     */
    public function removeScenarii(\Flosy\Bundle\UseCaseBundle\Entity\Scenario $scenarii)
    {
        $this->scenarii->removeElement($scenarii);
    }

    /**
     * Get scenarii
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getScenarii()
    {
        return $this->scenarii;
    }

    /**
     * Add actors
     *
     * @param Flosy\Bundle\UseCaseBundle\Entity\Actor $actors
     * @return UseCase
     */
    public function addActor(\Flosy\Bundle\UseCaseBundle\Entity\Actor $actors)
    {
        $this->actors[] = $actors;
    
        return $this;
    }

    /**
     * Remove actors
     *
     * @param Flosy\Bundle\UseCaseBundle\Entity\Actor $actors
     */
    public function removeActor(\Flosy\Bundle\UseCaseBundle\Entity\Actor $actors)
    {
        $this->actors->removeElement($actors);
    }

    /**
     * Get actors
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getActors()
    {
        return $this->actors;
    }

    /**
     * Set project
     *
     * @param \Flosy\Bundle\UseCaseBundle\Entity\Project $project
     * @return UseCase
     */
    public function setProject(\Flosy\Bundle\UseCaseBundle\Entity\Project $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get project
     *
     * @return \Flosy\Bundle\UseCaseBundle\Entity\Project 
     */
    public function getProject()
    {
        return $this->project;
    }
    
    public function __toString() {
        return $this->getTitle();
    }
}
