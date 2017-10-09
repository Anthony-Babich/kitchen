<?php

namespace Kuhni\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Kuhni
 *
 * @ORM\Table(name="kuhni")
 * @ORM\Entity(repositoryClass="Kuhni\Bundle\Repository\KuhniRepository")
 */
class Kuhni
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
     * @var boolean
     *
     * @ORM\Column(name="fixedPrice", type="boolean")
     */
    private $fixedPrice;

    /**
     * @return bool
     */
    public function isFixedPrice(): bool
    {
        return $this->fixedPrice;
    }

    /**
     * @param bool $fixedPrice
     * @return Kuhni
     */
    public function setFixedPrice(bool $fixedPrice)
    {
        $this->fixedPrice = $fixedPrice;
        return $this;
    }

    /**
     * @var KuhniStyle
     *
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\KuhniStyle", cascade={"persist"})
     * @ORM\JoinColumn(name="id_kuhni_style", referencedColumnName="id")
     */
    private $idKuhniStyle;

    /**
     * @var KuhniMaterial
     *
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\KuhniMaterial", cascade={"persist"})
     * @ORM\JoinColumn(name="id_kuhni_material", referencedColumnName="id")
     */
    private $idKuhniMaterial;

    /**
     * @var KuhniConfig
     *
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\KuhniConfig", cascade={"persist"})
     * @ORM\JoinColumn(name="id_kuhni_config", referencedColumnName="id")
     */
    private $idKuhniConfig;

    /**
     * @var KuhniColor
     *
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\KuhniColor", cascade={"persist"})
     * @ORM\JoinColumn(name="id_kuhni_color", referencedColumnName="id")
     */
    private $idKuhniColor;

    /**
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     * @return Kuhni
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="imageName", size="imageSize")
     *
     * @var File
     */
    private $imageFile;
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageName;
    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $imageSize;
    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updated;

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return Kuhni
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
     *
     * @return Kuhni
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
     *
     * @return Kuhni
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
     * @return KuhniStyle
     */
    public function getIdKuhniStyle(): KuhniStyle
    {
        return $this->idKuhniStyle;
    }

    /**
     * @param KuhniStyle $idKuhniStyle
     * @return Kuhni
     */
    public function setIdKuhniStyle(KuhniStyle $idKuhniStyle)
    {
        $this->idKuhniStyle = $idKuhniStyle;
        return $this;
    }

    /**
     * @return KuhniMaterial
     */
    public function getIdKuhniMaterial(): KuhniMaterial
    {
        return $this->idKuhniMaterial;
    }

    /**
     * @param KuhniMaterial $idKuhniMaterial
     * @return Kuhni
     */
    public function setIdKuhniMaterial(KuhniMaterial $idKuhniMaterial)
    {
        $this->idKuhniMaterial = $idKuhniMaterial;
        return $this;
    }

    /**
     * @return KuhniConfig
     */
    public function getIdKuhniConfig(): KuhniConfig
    {
        return $this->idKuhniConfig;
    }

    /**
     * @param KuhniConfig $idKuhniConfig
     * @return Kuhni
     */
    public function setIdKuhniConfig(KuhniConfig $idKuhniConfig)
    {
        $this->idKuhniConfig = $idKuhniConfig;
        return $this;
    }

    /**
     * @return KuhniColor
     */
    public function getIdKuhniColor(): KuhniColor
    {
        return $this->idKuhniColor;
    }

    /**
     * @param KuhniColor $idKuhniColor
     * @return Kuhni
     */
    public function setIdKuhniColor(KuhniColor $idKuhniColor)
    {
        $this->idKuhniColor = $idKuhniColor;
        return $this;
    }

    /**
     * @var Catalog
     *
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\Catalog", cascade={"persist"})
     * @ORM\JoinColumn(name="id_catalog", referencedColumnName="id")
     */
    private $idCatalog;

    /**
     * @return Catalog
     */
    public function getIdCatalog(): Catalog
    {
        return $this->idCatalog;
    }

    /**
     * @param Catalog $idCatalog
     * @return Kuhni
     */
    public function setIdCatalog(Catalog $idCatalog)
    {
        $this->idCatalog = $idCatalog;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return Kuhni
     */
    public function setPrice(int $price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return int
     */
    public function getDiscount(): int
    {
        return $this->discount;
    }

    /**
     * @param int $discount
     * @return Kuhni
     */
    public function setDiscount(int $discount)
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="price", type="integer")
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="discount", type="integer")
     */
    private $discount;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return Kuhni
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="keywords", type="string", length=255)
     */
    private $keywords;

    /**
     * @var string
     *
     * @ORM\Column(name="main_description", type="string", length=255)
     */
    private $mainDescription;


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
     * @return Kuhni
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
     * Set title
     *
     * @param string $title
     *
     * @return Kuhni
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
     * Set description
     *
     * @param string $description
     *
     * @return Kuhni
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
     * Set keywords
     *
     * @param string $keywords
     *
     * @return Kuhni
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set mainDescription
     *
     * @param string $mainDescription
     *
     * @return Kuhni
     */
    public function setMainDescription($mainDescription)
    {
        $this->mainDescription = $mainDescription;

        return $this;
    }

    /**
     * Get mainDescription
     *
     * @return string
     */
    public function getMainDescription()
    {
        return $this->mainDescription;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return strval($this->id);
    }
}

