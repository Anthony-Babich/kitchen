<?php

namespace Kuhni\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salon
 *
 * @ORM\Table(name="salon")
 * @ORM\Entity(repositoryClass="Kuhni\Bundle\Repository\SalonRepository")
 */
class Salon
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="longitude", type="string", length=255)
     */
    private $longitude;

    /**
     * @var string
     *
     * @ORM\Column(name="latitude", type="string", length=255)
     */
    private $latitude;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     *
     * @ORM\Column(name="workingHours", type="string", length=255)
     */
    private $workingHours;

    /**
     * @var string
     *
     * @ORM\Column(name="tc", type="string", length=255)
     */
    private $tc;

    /**
     * @var Salon $metroId
     *
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\StationMoscow")
     * @ORM\JoinColumn(name="metro_id", referencedColumnName="id")
     */
    private $metroId;

    /**
     * @var string
     *
     * @ORM\Column(name="gorod", type="string", length=255)
     */
    private $gorod;

    /**
     * @var boolean
     *
     * @ORM\Column(name="vivodKarta", type="boolean")
     */
    private $vivodKarta = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="vivodSelect", type="boolean")
     */
    private $vivodSelect = 0;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isVivodKarta(): bool
    {
        return $this->vivodKarta;
    }

    /**
     * @param bool $vivodKarta
     */
    public function setVivodKarta(bool $vivodKarta)
    {
        $this->vivodKarta = $vivodKarta;
    }

    /**
     * @return bool
     */
    public function isVivodSelect(): bool
    {
        return $this->vivodSelect;
    }

    /**
     * @param bool $vivodSelect
     */
    public function setVivodSelect(bool $vivodSelect)
    {
        $this->vivodSelect = $vivodSelect;
    }

    /**
     * Set longitude
     *
     * @param string $longitude
     *
     * @return Salon
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param string $latitude
     *
     * @return Salon
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Salon
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
     * Set title
     *
     * @param string $title
     *
     * @return Salon
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
     * Set address
     *
     * @param string $address
     *
     * @return Salon
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set workingHours
     *
     * @param string $workingHours
     *
     * @return Salon
     */
    public function setWorkingHours($workingHours)
    {
        $this->workingHours = $workingHours;

        return $this;
    }

    /**
     * Get workingHours
     *
     * @return string
     */
    public function getWorkingHours()
    {
        return $this->workingHours;
    }

    /**
     * Set tc
     *
     * @param string $tc
     *
     * @return Salon
     */
    public function setTc($tc)
    {
        $this->tc = $tc;

        return $this;
    }

    /**
     * Get tc
     *
     * @return string
     */
    public function getTc()
    {
        return $this->tc;
    }

    /**
     * Set metroId
     *
     * @param string $metroId
     *
     * @return Salon
     */
    public function setMetroId($metroId)
    {
        $this->metroId = $metroId;

        return $this;
    }

    /**
     * Get metroId
     *
     * @return string
     */
    public function getMetroId()
    {
        return $this->metroId;
    }

    /**
     * Set gorod
     *
     * @param string $gorod
     *
     * @return Salon
     */
    public function setGorod($gorod)
    {
        $this->gorod = $gorod;

        return $this;
    }

    /**
     * Get gorod
     *
     * @return string
     */
    public function getGorod()
    {
        return $this->gorod;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return strval($this->id);
    }
}

