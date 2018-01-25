<?php

namespace Kuhni\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormRequestCall
 * @ORM\Table(name="form_request_call")
 * @ORM\Entity(repositoryClass="Kuhni\Bundle\Repository\FormRequestCallRepository")
 */
class FormRequestCall
{
    use TraitId;

    /**
     * FormRequestCall constructor.
     */
    public function __construct()
    {
        $this->setCreated(new \DateTime());
    }

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     * @ORM\Column(name="geoIP", type="string", length=255)
     */
    private $geoIP;

    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var \DateTime
     * @ORM\Column(name="created", type="datetime")
     */
    private $created;

    /**
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\Salon", cascade={"persist"})
     * @ORM\JoinColumn(name="id_salon", referencedColumnName="id")
     */
    private $idSalon;

    /**
     * Set name
     * @param string $name
     * @return FormRequestCall
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set phone
     * @param string $phone
     * @return FormRequestCall
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Get phone
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set geoIP
     * @param string $geoIP
     * @return FormRequestCall
     */
    public function setGeoIP($geoIP)
    {
        $this->geoIP = $geoIP;
        return $this;
    }

    /**
     * Get geoIP
     * @return string
     */
    public function getGeoIP()
    {
        return $this->geoIP;
    }

    /**
     * Set url
     * @param string $url
     * @return FormRequestCall
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Get url
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set created
     * @param \DateTime $created
     * @return FormRequestCall
     */
    public function setCreated($created)
    {
        $this->created = $created;
        return $this;
    }

    /**
     * Get created
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Get idSalon
     * @return mixed
     */
    public function getIdSalon()
    {
        return $this->idSalon;
    }

    /**
     * Set idSalon
     * @param mixed $idSalon
     */
    public function setIdSalon($idSalon)
    {
        $this->idSalon = $idSalon;
    }
}