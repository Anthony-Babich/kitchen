<?php

namespace Kuhni\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FormPromo
 *
 * @ORM\Table(name="form_promo")
 * @ORM\Entity(repositoryClass="Kuhni\Bundle\Repository\FormPromoRepository")
 */
class FormPromo
{
    use TraitId;

    /**
     * FormPromo constructor.
     */
    public function __construct()
    {
        $this->setCreated(new \DateTime());
    }

    /**
     * @var \DateTime
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;

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
     * @ORM\Column(name="gorod", type="string", length=255)
     */
    private $gorod;

    /**
     * @var string
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(name="discount", type="string", length=255)
     */
    private $discount;

    /**
     * @var string
     * @ORM\Column(name="url", type="string", length=255)
     */
    private $url;

    /**
     * @var string
     * @ORM\Column(name="geoIP", type="string", length=255)
     */
    private $geoIP;

    /**
     * Set geoIP
     * @param string $geoIP
     * @return FormPromo
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
     * Set name
     * @param string $name
     * @return FormPromo
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
     * Set discount
     * @param string $discount
     * @return FormPromo
     */
    public function setDiscount($discount)
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * Get discount
     * @return string
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * Set phone
     * @param string $phone
     * @return FormPromo
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
     * Set gorod
     * @param string $gorod
     * @return FormPromo
     */
    public function setGorod($gorod)
    {
        $this->gorod = $gorod;
        return $this;
    }

    /**
     * Get gorod
     * @return string
     */
    public function getGorod()
    {
        return $this->gorod;
    }

    /**
     * Set email
     * @param string $email
     * @return FormPromo
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
     * Set url
     * @param string $url
     * @return FormPromo
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
     * @return FormPromo
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
}