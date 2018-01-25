<?php

namespace Kuhni\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Project
 * @Vich\Uploadable
 *
 * @ORM\Table(name="project")
 * @ORM\Entity(repositoryClass="Kuhni\Bundle\Repository\ProjectRepository")
 */
class Project
{
    use TraitId;

    public function __construct()
    {
        $this->fasadColors = new ArrayCollection();
        $this->fasadTypes = new ArrayCollection();
        $this->kuhniKeys = new ArrayCollection();
    }

    /**
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\Salon", cascade={"persist"})
     * @ORM\JoinColumn(name="id_salon", referencedColumnName="id")
     */
    private $idSalon;

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

    /**
     * @ORM\ManyToMany(targetEntity="Kuhni\Bundle\Entity\KuhniKeys")
     * @ORM\JoinTable(name="keys_projects",
     *   joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName = "id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="key_id", referencedColumnName="id")}
     * )
     */
    protected $kuhniKeys = array();

    /**
     * @return mixed
     */
    public function getKuhniKeys()
    {
        return $this->kuhniKeys;
    }

    /**
     * @param KuhniKeys $array
     * @return Project
     */
    public function addKuhniKeys(KuhniKeys $array)
    {
        $this->kuhniKeys[] = $array;
        return $this;
    }

    /**
     * @param KuhniKeys $element
     * @return Project
     */
    public function removeKuhniKeys(KuhniKeys $element)
    {
        $this->kuhniKeys->removeElement($element);
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
     * @var float
     *
     * @ORM\Column(name="price", type="float")
     */
    private $price;
    /**
     * @var integer
     *
     * @ORM\Column(name="likes", type="integer")
     */
    private $likes;

    /**
     * @var integer
     *
     * @ORM\Column(name="count_projects", type="integer")
     */
    private $countProjects;

    /**
     * @var float
     *
     * @ORM\Column(name="discount", type="float")
     */
    private $discount;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="fixedPrice", type="boolean")
     */
    private $fixedPrice = false;

    /**
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=50)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="article", type="string", length=3000)
     */
    private $article = '.';

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=1000)
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
     * @ORM\ManyToMany(targetEntity="Kuhni\Bundle\Entity\FasadColor")
     * @ORM\JoinTable(name="fasadColor_project",
     *   joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName = "id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="fasadColors_id", referencedColumnName="id")}
     * )
     */
    protected $fasadColors = array();

    /**
     * @return mixed
     */
    public function getFasadColors()
    {
        return $this->fasadColors;
    }

    /**
     * @param FasadColor $array
     * @return Project
     */
    public function addFasadColors(FasadColor $array)
    {
        $this->fasadColors[] = $array;
        return $this;
    }

    /**
     * @param FasadColor $element
     * @return Project
     */
    public function removeFasadColors(FasadColor $element)
    {
        $this->fasadColors->removeElement($element);
        return $this;
    }

    /**
     * @ORM\ManyToMany(targetEntity="Kuhni\Bundle\Entity\FasadType")
     * @ORM\JoinTable(name="fasadType_project",
     *   joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName = "id")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="fasadTypes_id", referencedColumnName="id")}
     * )
     */
    protected $fasadTypes = array();

    /**
     * @return mixed
     */
    public function getFasadTypes()
    {
        return $this->fasadTypes;
    }

    /**
     * @param FasadType $array
     * @return Project
     */
    public function addFasadTypes(FasadType $array)
    {
        $this->fasadTypes[] = $array;
        return $this;
    }

    /**
     * @param FasadType $element
     * @return Project
     */
    public function removeFasadTypes(FasadType $element)
    {
        $this->fasadTypes->removeElement($element);
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
     */
    public function setArticle(string $article = ' ')
    {
        $this->article = $article;
    }

    /**
     * @return int
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @param int $likes
     */
    public function setLikes(int $likes)
    {
        $this->likes = $likes;
    }

    /**
     * @return int
     */
    public function getCountProjects()
    {
        return $this->countProjects;
    }

    /**
     * @param int $countProjects
     */
    public function setCountProjects(int $countProjects)
    {
        $this->countProjects = $countProjects;
    }

    /**
     * @return bool
     */
    public function isFixedPrice()
    {
        return $this->fixedPrice;
    }

    /**
     * @param bool $fixedPrice
     * @return Project
     */
    public function setFixedPrice(bool $fixedPrice)
    {
        $this->fixedPrice = $fixedPrice;
        return $this;
    }

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="kuhni", fileNameProperty="imageName", size="imageSize")
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
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     * @return Project
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     * @return Project
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
     * @return Project
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
     * @return Project
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
     * @return Catalog
     */
    public function getIdCatalog()
    {
        return $this->idCatalog;
    }

    /**
     * @param Catalog $idCatalog
     * @return Project
     */
    public function setIdCatalog(Catalog $idCatalog)
    {
        $this->idCatalog = $idCatalog;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Project
     */
    public function setPrice(float $price)
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param float $discount
     * @return Project
     */
    public function setDiscount(float $discount)
    {
        $this->discount = $discount;
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
     * @return Project
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * Set name
     * @param string $name
     * @return Project
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
     * Set title
     * @param string $title
     * @return Project
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
     * Set description
     * @param string $description
     * @return Project
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
     * Set keywords
     * @param string $keywords
     * @return Project
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;
        return $this;
    }

    /**
     * Get keywords
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set mainDescription
     * @param string $mainDescription
     * @return Project
     */
    public function setMainDescription($mainDescription)
    {
        $this->mainDescription = $mainDescription;
        return $this;
    }

    /**
     * Get mainDescription
     * @return string
     */
    public function getMainDescription()
    {
        return $this->mainDescription;
    }

    /**
     * @return string
     */
    public function getRazmer()
    {
        return $this->razmer;
    }

    /**
     * @param string $razmer
     * @return Project
     */
    public function setRazmer(string $razmer)
    {
        $this->razmer = $razmer;
        return $this;
    }

    /**
     * @return string
     */
    public function getNameFasad()
    {
        return $this->nameFasad;
    }

    /**
     * @param string $nameFasad
     * @return Project
     */
    public function setNameFasad(string $nameFasad)
    {
        $this->nameFasad = $nameFasad;
        return $this;
    }

    /**
     * @return string
     */
    public function getMatFasad()
    {
        return $this->matFasad;
    }

    /**
     * @param string $matFasad
     * @return Project
     */
    public function setMatFasad(string $matFasad)
    {
        $this->matFasad = $matFasad;
        return $this;
    }

    /**
     * @return string
     */
    public function getStoleshnica()
    {
        return $this->stoleshnica;
    }

    /**
     * @param string $stoleshnica
     * @return Project
     */
    public function setStoleshnica(string $stoleshnica)
    {
        $this->stoleshnica = $stoleshnica;
        return $this;
    }

    /**
     * @return string
     */
    public function getKorpus()
    {
        return $this->korpus;
    }

    /**
     * @param string $korpus
     * @return Project
     */
    public function setKorpus(string $korpus)
    {
        $this->korpus = $korpus;
        return $this;
    }

    /**
     * @return string
     */
    public function getFurnitura()
    {
        return $this->furnitura;
    }

    /**
     * @param string $furnitura
     * @return Project
     */
    public function setFurnitura(string $furnitura)
    {
        $this->furnitura = $furnitura;
        return $this;
    }

    /**
     * @var string
     * @ORM\Column(name="razmer", type="string")
     */
    private $razmer;

    /**
     * @var string
     * @ORM\Column(name="nameFasad", type="string")
     */
    private $nameFasad;

    /**
     * @var string
     * @ORM\Column(name="matFasad", type="string")
     */
    private $matFasad;

    /**
     * @var string
     * @ORM\Column(name="stoleshnica", type="string")
     */
    private $stoleshnica;

    /**
     * @var string
     * @ORM\Column(name="korpus", type="string")
     */
    private $korpus;

    /**
     * @var string
     * @ORM\Column(name="furnitura", type="string")
     */
    private $furnitura;
}