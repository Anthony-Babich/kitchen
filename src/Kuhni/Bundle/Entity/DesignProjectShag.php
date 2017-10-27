<?php

namespace Kuhni\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * DesignProjectShag
 *
 * @ORM\Table(name="design_project_shag")
 * @ORM\Entity(repositoryClass="Kuhni\Bundle\Repository\DesignProjectShagRepository")
 */
class DesignProjectShag
{
    /**
     * CallBack constructor.
     */
    public function __construct()
    {
        $this->setCreated(new \DateTime());
    }

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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=255)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="geoIP", type="string", length=255)
     */
    private $geoIP;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

    /**
     * @var string
     *
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     *
     * @ORM\Column(name="style", type="string", length=255)
     */
    private $style;

    /**
     * @var string
     *
     * @ORM\Column(name="config", type="string", length=255)
     */
    private $config;


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
     * Set name
     *
     * @param string $name
     *
     * @return DesignProjectShag
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
     * Set email
     *
     * @param string $email
     *
     * @return DesignProjectShag
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return DesignProjectShag
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set geoIP
     *
     * @param string $geoIP
     *
     * @return DesignProjectShag
     */
    public function setGeoIP($geoIP)
    {
        $this->geoIP = $geoIP;

        return $this;
    }

    /**
     * Get geoIP
     *
     * @return string
     */
    public function getGeoIP()
    {
        return $this->geoIP;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return DesignProjectShag
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return DesignProjectShag
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getStyle(): string
    {
        return $this->style;
    }

    /**
     * @param string $style
     * @return DesignProjectShag
     */
    public function setStyle(string $style)
    {
        $this->style = $style;
        return $this;
    }

    /**
     * @return string
     */
    public function getConfig(): string
    {
        return $this->config;
    }

    /**
     * @param string $config
     * @return DesignProjectShag
     */
    public function setConfig(string $config)
    {
        $this->config = $config;
        return $this;
    }
}