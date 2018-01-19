<?php

namespace Kuhni\Bundle\Entity\Search;

use Doctrine\ORM\Mapping as ORM;
use Kuhni\Bundle\Entity\Salon;

class ZovZakaz
{

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=255)
     */
    private $number;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\Salon", cascade={"persist"})
     * @ORM\JoinColumn(name="id_salon", referencedColumnName="id")
     */
    private $idSalon;

    /**
     * Set number
     *
     * @param string $number
     *
     * @return ZovZakaz
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return ZovZakaz
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
     * @return mixed
     */
    public function getIdSalon()
    {
        return $this->idSalon;
    }

    /**
     * @param Salon $idSalon
     * @return ZovZakaz
     */
    public function setIdSalon(Salon $idSalon)
    {
        $this->idSalon = $idSalon;
        return $this;
    }
}