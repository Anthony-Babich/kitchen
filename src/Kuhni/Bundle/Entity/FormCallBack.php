<?php

namespace Kuhni\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormCallBack
 *
 * @ORM\Table(name="form_call_back")
 * @ORM\Entity(repositoryClass="Kuhni\Bundle\Repository\FormCallBackRepository")
 */
class FormCallBack
{
    use TraitId;

    /**
     * FormCallBack constructor.
     */
    public function __construct()
    {
        $this->setCreated(new \DateTime());
    }

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
     * @var string
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

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
     * @var \DateTime
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     * @ORM\Column(name="message", type="string", length=255)
     */
    private $message;

    /**
     * Set name
     * @param string $name
     * @return FormCallBack
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
     * Set email
     * @param string $email
     * @return FormCallBack
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Get email
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     * @param string $phone
     * @return FormCallBack
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
     * @return FormCallBack
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
     * Set created
     * @param \DateTime $created
     * @return FormCallBack
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
     * Set url
     * @param string $url
     * @return FormCallBack
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
     * Set message
     * @param string $message
     * @return FormCallBack
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
     * @return mixed
     */
    public function getIdSalon()
    {
        return $this->idSalon;
    }

    /**
     * @param mixed $idSalon
     * @return FormCallBack
     */
    public function setIdSalon($idSalon)
    {
        $this->idSalon = $idSalon;
        return $this;
    }
}