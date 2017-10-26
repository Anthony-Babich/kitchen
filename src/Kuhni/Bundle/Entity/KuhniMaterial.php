<?php

namespace Kuhni\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Kuhni\Bundle\Admin\KuhniMaterialAdmin;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * KuhniMaterial
 * @Vich\Uploadable
 *
 * @ORM\Table(name="kuhni_material")
 * @ORM\Entity(repositoryClass="Kuhni\Bundle\Repository\KuhniMaterialRepository")
 */
class KuhniMaterial
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
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var KuhniMassive
     *
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\KuhniMassive", cascade={"persist"})
     * @ORM\JoinColumn(name="id_massive", referencedColumnName="id")
     */
    private $idMassive;

    /**
     * @var KuhniMdf
     *
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\KuhniMdf", cascade={"persist"})
     * @ORM\JoinColumn(name="id_mdf", referencedColumnName="id")
     */
    private $idMdf;

    /**
     * @var KuhniPlastic
     *
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\KuhniPlastic", cascade={"persist"})
     * @ORM\JoinColumn(name="id_plastic", referencedColumnName="id")
     */
    private $idPlastic;

    /**
     * @var KuhniGlass
     *
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\KuhniGlass", cascade={"persist"})
     * @ORM\JoinColumn(name="id_glass", referencedColumnName="id")
     */
    private $idGlass;

    /**
     * @var KuhniAcryl
     *
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\KuhniAcryl", cascade={"persist"})
     * @ORM\JoinColumn(name="id_acryl", referencedColumnName="id")
     */
    private $idAcryl;

    /**
     * @var KuhniShpon
     *
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\KuhniShpon", cascade={"persist"})
     * @ORM\JoinColumn(name="id_shpon", referencedColumnName="id")
     */
    private $idShpon;

    /**
     * @var KuhniDSP
     *
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\KuhniDSP", cascade={"persist"})
     * @ORM\JoinColumn(name="id_dsp", referencedColumnName="id")
     */
    private $idDSP;

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
     * @var string
     *
     * @ORM\Column(name="slug", type="string", length=255)
     */
    private $slug;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="kuhni_material", fileNameProperty="imageName", size="imageSize")
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
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param string $slug
     * @return KuhniMaterial
     */
    public function setSlug(string $slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return KuhniMdf
     */
    public function getIdMdf()
    {
        return $this->idMdf;
    }

    /**
     * @param KuhniMdf $idMdf
     * @return KuhniMaterial
     */
    public function setIdMdf(KuhniMdf $idMdf)
    {
        $this->idMdf = $idMdf;
        return $this;
    }

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
     * Set title
     *
     * @param string $title
     *
     * @return KuhniMaterial
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
     * @return KuhniMassive
     */
    public function getIdMassive()
    {
        return $this->idMassive;
    }

    /**
     * @param KuhniMassive $idMassive
     * @return KuhniMaterial
     */
    public function setIdMassive(KuhniMassive $idMassive)
    {
        $this->idMassive = $idMassive;
        return $this;
    }

    /**
     * Set keywords
     *
     * @param string $keywords
     *
     * @return KuhniMaterial
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
     * @return KuhniMaterial
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
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    /**
     * @param \DateTime $updated
     * @return KuhniMaterial
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
        return $this;
    }
    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return KuhniMaterial
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
     * @return KuhniMaterial
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
     * @return KuhniMaterial
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
     * @return KuhniPlastic
     */
    public function getIdPlastic()
    {
        return $this->idPlastic;
    }

    /**
     * @param KuhniPlastic $idPlastic
     * @return KuhniMaterial
     */
    public function setIdPlastic(KuhniPlastic $idPlastic)
    {
        $this->idPlastic = $idPlastic;
        return $this;
    }

    /**
     * @return KuhniGlass
     */
    public function getIdGlass()
    {
        return $this->idGlass;
    }

    /**
     * @param KuhniGlass $idGlass
     * @return KuhniMaterial
     */
    public function setIdGlass(KuhniGlass $idGlass)
    {
        $this->idGlass = $idGlass;
        return $this;
    }

    /**
     * @return KuhniAcryl
     */
    public function getIdAcryl()
    {
        return $this->idAcryl;
    }

    /**
     * @param KuhniAcryl $idAcryl
     * @return KuhniMaterial
     */
    public function setIdAcryl(KuhniAcryl $idAcryl)
    {
        $this->idAcryl = $idAcryl;
        return $this;
    }

    /**
     * @return KuhniShpon
     */
    public function getIdShpon()
    {
        return $this->idShpon;
    }

    /**
     * @param KuhniShpon $idShpon
     * @return KuhniMaterial
     */
    public function setIdShpon(KuhniShpon $idShpon)
    {
        $this->idShpon = $idShpon;
        return $this;
    }

    /**
     * @return KuhniDSP
     */
    public function getIdDSP()
    {
        return $this->idDSP;
    }

    /**
     * @param KuhniDSP $idDSP
     * @return KuhniMaterial
     */
    public function setIdDSP(KuhniDSP $idDSP)
    {
        $this->idDSP = $idDSP;
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