<?php

namespace Controlcar\JournalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="act")
 */
class Act
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $name;

    /**
     * @ORM\Column(type="date")
     */
    protected $date;

    /**
     * @ORM\Column(type="integer")
     */
    protected $car_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $weight;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $cargo_type;

    /**
     * @ORM\Column(type="integer")
     */
    protected $transposition_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $distance;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $price_by_km;

    /**
     * @ORM\Column(type="integer")
     */
    protected $count_transportation;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    protected $price_by_transportation;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $departure_place;

    /**
     * @ORM\Column(type="string", length=100)
     */
    protected $destination_place;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $edit_time;

    /**
     * @param mixed $edit_time
     */
    public function setEditTime($edit_time)
    {
        $this->edit_time = $edit_time;
    }

    /**
     * @return mixed
     */
    public function getEditTime()
    {
        return $this->edit_time;
    }

    /**
     * @ORM\ManyToOne(targetEntity="Car", inversedBy="acts")
     * @ORM\JoinColumn(name="car_id", referencedColumnName="id")
     */
    protected $car;

    /**
     * @ORM\ManyToOne(targetEntity="Transposition", inversedBy="acts")
     * @ORM\JoinColumn(name="transposition_id", referencedColumnName="id")
     */
    protected $transposition;


    /**
     * Get id
     *
     * @return integer
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * @return Act
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
     * Set date
     *
     * @param \DateTime $date
     * @return Act
     */
    public function setDate($date)
    {
        $this->date = $date;
    
        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     * @return Act
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    
        return $this;
    }

    /**
     * Get weight
     *
     * @return integer 
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set distance
     *
     * @param integer $distance
     * @return Act
     */
    public function setDistance($distance)
    {
        $this->distance = $distance;
    
        return $this;
    }

    /**
     * Get distance
     *
     * @return integer 
     */
    public function getDistance()
    {
        return $this->distance;
    }

    /**
     * Set price_by_km
     *
     * @param float $priceByKm
     * @return Act
     */
    public function setPriceByKm($priceByKm)
    {
        $this->price_by_km = $priceByKm;
    
        return $this;
    }

    /**
     * Get price_by_km
     *
     * @return float 
     */
    public function getPriceByKm()
    {
        return $this->price_by_km;
    }

    /**
     * Set count_transportation
     *
     * @param integer $countTransportation
     * @return Act
     */
    public function setCountTransportation($countTransportation)
    {
        $this->count_transportation = $countTransportation;
    
        return $this;
    }

    /**
     * Get count_transportation
     *
     * @return integer 
     */
    public function getCountTransportation()
    {
        return $this->count_transportation;
    }

    /**
     * Set price_by_transportation
     *
     * @param float $priceByTransportation
     * @return Act
     */
    public function setPriceByTransportation($priceByTransportation)
    {
        $this->price_by_transportation = $priceByTransportation;
    
        return $this;
    }

    /**
     * Get price_by_transportation
     *
     * @return float 
     */
    public function getPriceByTransportation()
    {
        return $this->price_by_transportation;
    }

    /**
     * Set departure_place
     *
     * @param string $departurePlace
     * @return Act
     */
    public function setDeparturePlace($departurePlace)
    {
        $this->departure_place = $departurePlace;
    
        return $this;
    }

    /**
     * Get departure_place
     *
     * @return string 
     */
    public function getDeparturePlace()
    {
        return $this->departure_place;
    }

    /**
     * Set destination_place
     *
     * @param string $destinationPlace
     * @return Act
     */
    public function setDestinationPlace($destinationPlace)
    {
        $this->destination_place = $destinationPlace;
    
        return $this;
    }

    /**
     * Get destination_place
     *
     * @return string 
     */
    public function getDestinationPlace()
    {
        return $this->destination_place;
    }

    /**
     * Set car_id
     *
     * @param integer $carId
     * @return Act
     */
    public function setCarId($carId)
    {
        $this->car_id = $carId;
    
        return $this;
    }

    /**
     * Get car_id
     *
     * @return integer 
     */
    public function getCarId()
    {
        return $this->car_id;
    }

    /**
     * Set car
     *
     * @param \Controlcar\JournalBundle\Entity\Car $car
     * @return Act
     */
    public function setCar(\Controlcar\JournalBundle\Entity\Car $car = null)
    {
        $this->car = $car;
    
        return $this;
    }

    /**
     * Get car
     *
     * @return \Controlcar\JournalBundle\Entity\Car 
     */
    public function getCar()
    {
        return $this->car;
    }

    /**
     * Set transposition_id
     *
     * @param integer $transpositionId
     * @return Act
     */
    public function setTranspositionId($transpositionId)
    {
        $this->transposition_id = $transpositionId;
    
        return $this;
    }

    /**
     * Get transposition_id
     *
     * @return integer 
     */
    public function getTranspositionId()
    {
        return $this->transposition_id;
    }

    /**
     * Set transposition
     *
     * @param \Controlcar\JournalBundle\Entity\Transposition $transposition
     * @return Act
     */
    public function setTransposition(\Controlcar\JournalBundle\Entity\Transposition $transposition = null)
    {
        $this->transposition = $transposition;
    
        return $this;
    }

    /**
     * @param mixed $cargo_type
     */
    public function setCargoType($cargo_type)
    {
        $this->cargo_type = $cargo_type;
    }

    /**
     * @return mixed
     */
    public function getCargoType()
    {
        return $this->cargo_type;
    }

    /**
     * Get transposition
     *
     * @return \Controlcar\JournalBundle\Entity\Transposition 
     */
    public function getTransposition()
    {
        return $this->transposition;
    }
}