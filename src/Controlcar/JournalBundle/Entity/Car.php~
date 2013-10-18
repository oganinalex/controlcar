<?php
/**
 * Created by JetBrains PhpStorm.
 * User: alex
 * Date: 26.09.13
 * Time: 18:07
 * To change this template use File | Settings | File Templates.
 */

namespace Controlcar\JournalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * @ORM\Entity
 * @ORM\Table(name="car")
 */
class Car
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
     * @ORM\Column(type="string", length=10)
     */
    protected $car_number;

    /**
     * @ORM\Column(type="integer")
     */
    protected $car_weight;

    /**
     * @ORM\Column(type="string", length=25)
     */
    protected $vin_code;

    /**
     * @ORM\Column(type="string", length=25)
     */
    protected $driver_name;

    /**
     * @ORM\OneToMany(targetEntity="Act", mappedBy="car")
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
     * @return Car
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
     * Set car_number
     *
     * @param string $carNumber
     * @return Car
     */
    public function setCarNumber($carNumber)
    {
        $this->car_number = $carNumber;
    
        return $this;
    }

    /**
     * Get car_number
     *
     * @return string 
     */
    public function getCarNumber()
    {
        return $this->car_number;
    }

    /**
     * Set car_weight
     *
     * @param integer $carWeight
     * @return Car
     */
    public function setCarWeight($carWeight)
    {
        $this->car_weight = $carWeight;
    
        return $this;
    }

    /**
     * Get car_weight
     *
     * @return integer 
     */
    public function getCarWeight()
    {
        return $this->car_weight;
    }

    /**
     * Set vin_code
     *
     * @param string $vinCode
     * @return Car
     */
    public function setVinCode($vinCode)
    {
        $this->vin_code = $vinCode;
    
        return $this;
    }

    /**
     * Get vin_code
     *
     * @return string 
     */
    public function getVinCode()
    {
        return $this->vin_code;
    }

    /**
     * Set driver_name
     *
     * @param string $driverName
     * @return Car
     */
    public function setDriverName($driverName)
    {
        $this->driver_name = $driverName;
    
        return $this;
    }

    /**
     * Get driver_name
     *
     * @return string 
     */
    public function getDriverName()
    {
        return $this->driver_name;
    }

    /**
     * Add acts
     *
     * @param \Controlcar\JournalBundle\Entity\Act $acts
     * @return Car
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