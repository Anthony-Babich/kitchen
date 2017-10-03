<?php

namespace Kuhni\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

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

