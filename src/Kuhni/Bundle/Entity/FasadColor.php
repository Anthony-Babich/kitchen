<?php

namespace Kuhni\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * FasadColor
 *
 * @ORM\Table(name="fasad_color")
 * @ORM\Entity(repositoryClass="Kuhni\Bundle\Repository\FasadColorRepository")
 */
class FasadColor
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
     * @var KuhniMaterial
     *
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\KuhniMaterial", cascade={"persist"})
     * @ORM\JoinColumn(name="id_kuhni_material", referencedColumnName="id")
     */
    private $idKuhniMaterial;

    /**
     * @return KuhniMaterial
     */
    public function getIdCatalog(): Catalog
    {
        return $this->idKuhniMaterial;
    }

    /**
     * @param KuhniMaterial $idKuhniMaterial
     * @return FasadColor
     */
    public function setIdCatalog(Catalog $idKuhniMaterial)
    {
        $this->idKuhniMaterial = $idKuhniMaterial;

        return $this;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="KitchenMaterialId", type="string", length=255)
     */
    private $kitchenMaterialId;

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
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="alt", type="string", length=255)
     */
    private $alt;


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
     * Set kitchenMaterialId
     *
     * @param string $kitchenMaterialId
     *
     * @return FasadColor
     */
    public function setKitchenMaterialId($kitchenMaterialId)
    {
        $this->kitchenMaterialId = $kitchenMaterialId;

        return $this;
    }

    /**
     * Get kitchenMaterialId
     *
     * @return string
     */
    public function getKitchenMaterialId()
    {
        return $this->kitchenMaterialId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return FasadColor
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
     * @return FasadColor
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
     * Set image
     *
     * @param string $image
     *
     * @return FasadColor
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set alt
     *
     * @param string $alt
     *
     * @return FasadColor
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return strval($this->id);
    }
}

