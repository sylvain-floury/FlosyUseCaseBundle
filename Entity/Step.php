<?php

namespace Flosy\Bundle\UseCaseBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Flosy\Bundle\UseCaseBundle\Entity\Step
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Step
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
     * @var string $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var integer $position
     *
     * @ORM\Column(name="position", type="integer")
     */
    private $position;
    
    /**
     *
     * @ORM\ManyToOne(targetEntity="Scenario", inversedBy="steps")
     * @ORM\JoinColumn(name="scenario_id", referencedColumnName="id")
     */
    protected $scenario;


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
     * Set description
     *
     * @param string $description
     * @return Step
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set position
     *
     * @param integer $position
     * @return Step
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set scenario
     *
     * @param Flosy\Bundle\UseCaseBundle\Entity\Scenario $scenario
     * @return Step
     */
    public function setScenario(\Flosy\Bundle\UseCaseBundle\Entity\Scenario $scenario = null)
    {
        $this->scenario = $scenario;
    
        return $this;
    }

    /**
     * Get scenario
     *
     * @return Flosy\Bundle\UseCaseBundle\Entity\Scenario 
     */
    public function getScenario()
    {
        return $this->scenario;
    }
}
