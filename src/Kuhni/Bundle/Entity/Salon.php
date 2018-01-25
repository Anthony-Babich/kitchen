<?php

namespace Kuhni\Bundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Application\Sonata\UserBundle\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Salon
 * @Vich\Uploadable
 *
 * @ORM\Table(name="salon")
 * @ORM\Entity(repositoryClass="Kuhni\Bundle\Repository\SalonRepository")
 */
class Salon
{
    use TraitId;

    public function __construct()
    {
        $this->salonImages = new ArrayCollection();
    }

    /**
     * @var string
     * @ORM\Column(name="longitude", type="string", length=255)
     */
    private $longitude;

    /**
     * @var string
     * @ORM\Column(name="latitude", type="string", length=255)
     */
    private $latitude;

    /**
     * @var string
     * @ORM\Column(name="phone", type="string", length=30)
     */
    private $phone;

    /**
     * @var string
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     * @ORM\Column(name="address", type="string", length=255)
     */
    private $address;

    /**
     * @var string
     * @ORM\Column(name="workingHours", type="string", length=255)
     */
    private $workingHours;

    /**
     * @var string
     * @ORM\Column(name="tc", type="string", length=255)
     */
    private $tc;

    /**
     * @var Salon $metroId
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\StationMoscow")
     * @ORM\JoinColumn(name="metro_id", referencedColumnName="id")
     */
    private $metroId;

    /**
     * @var string
     * @ORM\Column(name="gorod", type="string", length=255)
     */
    private $gorod;

    /**
     * @var string
     * @ORM\Column(name="slugAddress", type="string", length=255)
     */
    private $slugAddress;

    /**
     * @var string
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    /**
     * @var string
     * @ORM\Column(name="article", type="string", length=3000)
     */
    private $article;

    /**
     * @var boolean
     *
     * @ORM\Column(name="vivodKarta", type="boolean")
     */
    private $vivodKarta = 0;

    /**
     * @var boolean
     * @ORM\Column(name="vivodSelect", type="boolean")
     */
    private $vivodSelect = 0;

    /**
     * @var Salon id_user
     * @ORM\ManyToOne(targetEntity="Application\Sonata\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $idUser;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @Vich\UploadableField(mapping="salon", fileNameProperty="imageName", size="imageSize")
     * @var File
     */
    private $imageFile;
    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $imageName;
    /**
     * @ORM\Column(type="integer")
     * @var integer
     */
    private $imageSize;
    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updated;

    /**
     * @return string
     */
    public function getSlugAddress()
    {
        return $this->slugAddress;
    }

    /**
     * @param string $slugAddress
     * @return Salon
     */
    public function setSlugAddress(string $slugAddress)
    {
        $this->slugAddress = $slugAddress;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Salon
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param string $phone
     * @return Salon
     */
    public function setPhone(string $phone)
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * @return string
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param string $article
     * @return Salon
     */
    public function setArticle(string $article)
    {
        $this->article = $article;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     * @return Salon
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     * @return Salon
     */
    public function setImageFile(File $image = null)
    {
        $this->imageFile = $image;
        if ($image) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updated = new \DateTimeImmutable();
        }
        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFile()
    {
        return $this->imageFile;
    }

    /**
     * @param string $imageName
     * @return Salon
     */
    public function setImageName($imageName)
    {
        $this->imageName = $imageName;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageName()
    {
        return $this->imageName;
    }

    /**
     * @param integer $imageSize
     * @return Salon
     */
    public function setImageSize($imageSize)
    {
        $this->imageSize = $imageSize;
        return $this;
    }

    /**
     * @return integer|null
     */
    public function getImageSize()
    {
        return $this->imageSize;
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
     * @return Salon
     */
    public function setVivodKarta(bool $vivodKarta)
    {
        $this->vivodKarta = $vivodKarta;
        return $this;
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
     * @return Salon
     */
    public function setVivodSelect(bool $vivodSelect)
    {
        $this->vivodSelect = $vivodSelect;
        return $this;
    }

    /**
     * Set longitude
     * @param string $longitude
     * @return Salon
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * Get longitude
     * @return string
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     * @param string $latitude
     * @return Salon
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * Get latitude
     * @return string
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set description
     * @param string $description
     * @return Salon
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set title
     * @param string $title
     * @return Salon
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Get title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set address
     * @param string $address
     * @return Salon
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Get address
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set workingHours
     * @param string $workingHours
     * @return Salon
     */
    public function setWorkingHours($workingHours)
    {
        $this->workingHours = $workingHours;
        return $this;
    }

    /**
     * Get workingHours
     * @return string
     */
    public function getWorkingHours()
    {
        return $this->workingHours;
    }

    /**
     * Set tc
     * @param string $tc
     * @return Salon
     */
    public function setTc($tc)
    {
        $this->tc = $tc;
        return $this;
    }

    /**
     * Get tc
     * @return string
     */
    public function getTc()
    {
        return $this->tc;
    }

    /**
     * Set metroId
     * @param string $metroId
     * @return Salon
     */
    public function setMetroId($metroId)
    {
        $this->metroId = $metroId;
        return $this;
    }

    /**
     * Get metroId
     * @return string
     */
    public function getMetroId()
    {
        return $this->metroId;
    }

    /**
     * Set gorod
     * @param string $gorod
     * @return Salon
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
     * Get idUser
     * @return string
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set idUser
     * @param User $idUser
     * @return Salon
     */
    public function setIdUser(User $idUser)
    {
        $this->idUser = $idUser;
        return $this;
    }
}