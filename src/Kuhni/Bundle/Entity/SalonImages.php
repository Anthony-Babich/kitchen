<?php

namespace Kuhni\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * SalonImages
 * @Vich\Uploadable
 *
 * @ORM\Table(name="salon_images")
 * @ORM\Entity(repositoryClass="Kuhni\Bundle\Repository\SalonImagesRepository")
 */
class SalonImages
{
    use TraitId;

    /**
     * @var Salon
     *
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\Salon", cascade={"persist"})
     * @ORM\JoinColumn(name="salon_id", referencedColumnName="id")
     */
    private $salonId;

    /**
     * @return Salon
     */
    public function getSalonId()
    {
        return $this->salonId;
    }

    /**
     * @param Salon $salonId
     * @return SalonImages
     */
    public function setSalonId(Salon $salonId)
    {
        $this->salonId = $salonId;
        return $this;
    }

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * Set title
     * @param string $title
     * @return SalonImages
     */
    public function setTitle($title)
    {
        $this->title = $title;
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
     * @return SalonImages
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @Vich\UploadableField(mapping="salon_all_images", fileNameProperty="imageName", size="imageSize")
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
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     * @return SalonImages
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
     * @return SalonImages
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
     * @return SalonImages
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
     * Get title
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}