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
     * @ORM\ManyToOne(targetEntity="UseCase", inversedBy="actors")
     * @ORM\JoinColumn(name="use_case_id", referencedColumnName="id")
     */
    protected $useCase;


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
     * Set useCase
     *
     * @param Flosy\Bundle\UseCaseBundle\Entity\UseCase $useCase
     * @return Actor
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
}