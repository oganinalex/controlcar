<?php

namespace Controlcar\JournalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="transposition")
 */
class Transposition
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="Act", mappedBy="transposition")
     */
    protected $acts;

    public function __construct()
    {
        $this->acts = new ArrayCollection();
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
     * Set name
     *
     * @param string $name
     * @return Transposition
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
     * Add acts
     *
     * @param \Controlcar\JournalBundle\Entity\Act $acts
     * @return Transposition
     */
    public function addAct(\Controlcar\JournalBundle\Entity\Act $acts)
    {
        $this->acts[] = $acts;
    
        return $this;
    }

    /**
     * Remove acts
     *
     * @param \Controlcar\JournalBundle\Entity\Act $acts
     */
    public function removeAct(\Controlcar\JournalBundle\Entity\Act $acts)
    {
        $this->acts->removeElement($acts);
    }

    /**
     * Get acts
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getActs()
    {
        return $this->acts;
    }
}