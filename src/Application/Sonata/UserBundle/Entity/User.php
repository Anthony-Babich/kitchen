<?php

namespace Application\Sonata\UserBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Kuhni\Bundle\Entity\Salon;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fos_user_user")
 */
class User extends BaseUser
{
    public function __construct()
    {
        parent::__construct();
        $this->salons = new ArrayCollection();
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
     * @ORM\ManyToMany(targetEntity="Kuhni\Bundle\Entity\Salon")
     * @ORM\JoinTable(name="user_salon",
     *   joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName = "id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="salon_id", referencedColumnName="id")}
     * )
     */
    protected $salons = array();

    /**
     * @return mixed
     */
    public function getSalons()
    {
        return $this->salons;
    }

    /**
     * @param Salon $array
     * @return User
     */
    public function addSalons(Salon $array)
    {
        $this->salons[] = $array;
        return $this;
    }

    /**
     * @param Salon $element
     * @return User
     */
    public function removeKuhniColors(Salon $element)
    {
        $this->salons->removeElement($element);
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return strval($this->id);
    }
}