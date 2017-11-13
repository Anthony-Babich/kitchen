<?php

namespace Application\Sonata\UserBundle\Entity;

use Kuhni\Bundle\Entity\StationMoscow;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user")
 */
class User extends BaseUser
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     *
     * @return int $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @var string $longitude
     *
     * @ORM\Column(name="longitude", type="string", length=255)
     */
    private $longitude;

    /**
     * @var string $longitude
     *
     * @ORM\Column(name="latitude", type="string", length=255)
     */
    private $latitude;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string $title
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string $address
     *
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string $workingHours
     *
     * @ORM\Column(name="workingHours", type="string", length=255)
     */
    private $workingHours;

    /**
     * @var string $tc
     *
     * @ORM\Column(name="tc", type="string", length=255)
     */
    private $tc;

    /**
     * @var User $metroId
     *
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\StationMoscow")
     * @ORM\JoinColumn(name="metro_id", referencedColumnName="id")
     */
    private $metroId;

    /**
     * @var string $gorod
     *
     * @ORM\Column(name="gorod", type="string", length=255)
     */
    private $gorod;

    /**
     * @var boolean $salon
     *
     * @ORM\Column(name="salon", type="boolean")
     */
    private $salon;

    /**
     * @return boolean
     */
    public function getSalon()
    {
        return $this->salon;
    }

    /**
     * @param boolean $salon
     */
    public function setSalon($salon)
    {
        $this->salon = $salon;
    }

    /**
     * @return User
     */
    public function getMetroId()
    {
        return $this->metroId;
    }

    /**
     * @param StationMoscow $metroId
     */
    public function setMetroId(StationMoscow $metroId)
    {
        $this->metroId = $metroId;
    }

    /**
     * @return string
     */
    public function getGorod()
    {
        return $this->gorod;
    }

    /**
     * @param string $gorod
     */
    public function setGorod(string $gorod)
    {
        $this->gorod = $gorod;
    }

    /**
     * @return string
     */
    public function getTc()
    {
        return $this->tc;
    }

    /**
     * @param string $tc
     */
    public function setTc(string $tc)
    {
        $this->tc = $tc;
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @param string $longitude
     */
    public function setLongitude(string $longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * @param string $latitude
     */
    public function setLatitude(string $latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getWorkingHours()
    {
        return $this->workingHours;
    }

    /**
     * @param string $workingHours
     */
    public function setWorkingHours(string $workingHours)
    {
        $this->workingHours = $workingHours;
    }
}