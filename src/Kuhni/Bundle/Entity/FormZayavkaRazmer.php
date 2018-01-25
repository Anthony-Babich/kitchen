<?php

namespace Kuhni\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormZayavkaRazmer
 * @ORM\Table(name="form_zayavka_razmer")
 * @ORM\Entity(repositoryClass="Kuhni\Bundle\Repository\FormZayavkaRazmerRepository")
 */
class FormZayavkaRazmer
{
    /**
     * FormZayavkaRazmer constructor.
     */
    public function __construct()
    {
        $this->setCreated(new \DateTime());
    }

    use TraitId;

    /**
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\Salon", cascade={"persist"})
     * @ORM\JoinColumn(name="id_salon", referencedColumnName="id")
     */
    private $idSalon;

    /**
     * @var string
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     * @ORM\Column(name="phone", type="integer")
     */
    private $phone;

    /**
     * @var string
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;

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
     * Set name
     * @param string $name
     * @return FormZayavkaRazmer
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
     * @param integer $phone
     * @return FormZayavkaRazmer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Get phone
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set message
     * @param string $message
     * @return FormZayavkaRazmer
     */
    public function setMessage($message)
    {
        $this->message = $message;
        return $this;
    }

    /**
     * Get message
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set geoIP
     * @param string $geoIP
     * @return FormZayavkaRazmer
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
     * @return FormZayavkaRazmer
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
     * @return FormZayavkaRazmer
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
     * @return mixed
     */
    public function getIdSalon()
    {
        return $this->idSalon;
    }

    /**
     * @param mixed $idSalon
     */
    public function setIdSalon($idSalon)
    {
        $this->idSalon = $idSalon;
    }
}