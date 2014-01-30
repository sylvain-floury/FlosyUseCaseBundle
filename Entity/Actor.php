<?php

namespace Flosy\Bundle\UseCaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Flosy\Bundle\UseCaseBundle\Entity\Actor
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Actor
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
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;
    
    /**
     *
     * @ORM\ManyToMany(targetEntity="UseCase", inversedBy="actors")
     * @ORM\JoinTable(name="users_groups")
     */
    protected $useCases;


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
     * @return Actor
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
     * Set type
     *
     * @param string $type
     * @return Actor
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

    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->useCases = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add useCases
     *
     * @param \Flosy\Bundle\UseCaseBundle\Entity\UseCase $useCases
     * @return Actor
     */
    public function addUseCase(\Flosy\Bundle\UseCaseBundle\Entity\UseCase $useCases)
    {
        $this->useCases[] = $useCases;

        return $this;
    }

    /**
     * Remove useCases
     *
     * @param \Flosy\Bundle\UseCaseBundle\Entity\UseCase $useCases
     */
    public function removeUseCase(\Flosy\Bundle\UseCaseBundle\Entity\UseCase $useCases)
    {
        $this->useCases->removeElement($useCases);
    }

    /**
     * Get useCases
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUseCases()
    {
        return $this->useCases;
    }
}