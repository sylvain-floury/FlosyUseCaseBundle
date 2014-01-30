<?php

namespace Flosy\Bundle\UseCaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Flosy\Bundle\UseCaseBundle\Entity\Scenario
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Scenario
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $type
     *
     * @ORM\Column(name="type", type="string", length=50)
     */
    private $type;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="UseCase", inversedBy="scenarii")
     * @ORM\JoinColumn(name="use_case_id", referencedColumnName="id")
     */
    protected $useCase;
    
    /**
     *
     * @ORM\OneToMany(targetEntity="Step", mappedBy="scenario") 
     */
    protected $steps;

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
     * Set name
     *
     * @param string $name
     * @return Scenario
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set useCase
     *
     * @param Flosy\Bundle\UseCaseBundle\Entity\UseCase $useCase
     * @return Scenario
     */
    public function setUseCase(\Flosy\Bundle\UseCaseBundle\Entity\UseCase $useCase = null)
    {
        $this->useCase = $useCase;
    
        return $this;
    }

    /**
     * Get useCase
     *
     * @return Flosy\Bundle\UseCaseBundle\Entity\UseCase 
     */
    public function getUseCase()
    {
        return $this->useCase;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->steps = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add steps
     *
     * @param Flosy\Bundle\UseCaseBundle\Entity\Step $steps
     * @return Scenario
     */
    public function addStep(\Flosy\Bundle\UseCaseBundle\Entity\Step $steps)
    {
        $this->steps[] = $steps;
    
        return $this;
    }

    /**
     * Remove steps
     *
     * @param Flosy\Bundle\UseCaseBundle\Entity\Step $steps
     */
    public function removeStep(\Flosy\Bundle\UseCaseBundle\Entity\Step $steps)
    {
        $this->steps->removeElement($steps);
    }

    /**
     * Get steps
     *
     * @return Doctrine\Common\Collections\Collection 
     */
    public function getSteps()
    {
        return $this->steps;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Scenario
     */
    public function setType($type)
    {
        $this->type = $type;
    
        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }
    
    public function __toString() 
    {
        return $this->name;
    }
}