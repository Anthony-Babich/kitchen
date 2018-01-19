<?php

namespace Kuhni\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * HomeSliderImages
 * @Vich\Uploadable
 *
 * @ORM\Table(name="home_slider_images")
 * @ORM\Entity(repositoryClass="Kuhni\Bundle\Repository\HomeSliderImagesRepository")
 */
class HomeSliderImages
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
     * @ORM\Column(name="link", type="string", nullable=true)
     */
    private $link = '';

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    private $title = '';

    /**
     * @var integer
     *
     * @ORM\Column(name="priority", type="integer")
     */
    private $priority = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="output", type="boolean")
     */
    private $output = 0;

    /**
     * @var boolean
     *
     * @ORM\Column(name="modal", type="boolean")
     */
    private $modal = 0;

    /**
     * @return bool
     */
    public function isModal()
    {
        return $this->modal;
    }

    /**
     * @param bool $modal
     * @return HomeSliderImages
     */
    public function setModal($modal)
    {
        $this->modal = $modal;
        return $this;
    }

    /**
     * @return bool
     */
    public function isOutput()
    {
        return $this->output;
    }

    /**
     * @param bool $output
     * @return HomeSliderImages
     */
    public function setOutput($output)
    {
        $this->output = $output;
        return $this;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     * @return HomeSliderImages
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
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
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param $title
     * @return HomeSliderImages
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param $link
     * @return HomeSliderImages
     */
    public function setLink($link)
    {
        $this->link = $link;
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
     * @return HomeSliderImages
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="kuhni_slider_home", fileNameProperty="imageNameIconNoHover", size="imageSizeIconNoHover")
     *
     * @var File
     */
    private $imageFileIconNoHover;
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageNameIconNoHover;
    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $imageSizeIconNoHover;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="kuhni_slider_home", fileNameProperty="imageNameIconOnHover", size="imageSizeIconOnHover")
     *
     * @var File
     */
    private $imageFileIconOnHover;
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageNameIconOnHover;
    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $imageSizeIconOnHover;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="kuhni_slider_home", fileNameProperty="imageNameBannerPC", size="imageSizeBannerPC")
     *
     * @var File
     */
    private $imageFileBannerPC;
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageNameBannerPC;
    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $imageSizeBannerPC;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="kuhni_slider_home", fileNameProperty="imageNameBannerMobile", size="imageSizeBannerMobile")
     *
     * @var File
     */
    private $imageFileBannerMobile;
    /**
     * @ORM\Column(type="string", length=255)
     *
     * @var string
     */
    private $imageNameBannerMobile;
    /**
     * @ORM\Column(type="integer")
     *
     * @var integer
     */
    private $imageSizeBannerMobile;
    /**
     * @ORM\Column(type="datetime")
     *
     * @var \DateTime
     */
    private $updated;

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return HomeSliderImages
     */
    public function setImageFileIconNoHover(File $image = null)
    {
        $this->imageFileIconNoHover = $image;

        if ($image) {
            $this->updated = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return HomeSliderImages
     */
    public function setImageFileIconOnHover(File $image = null)
    {
        $this->imageFileIconOnHover = $image;

        if ($image) {
            $this->updated = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return HomeSliderImages
     */
    public function setImageFileBannerPC(File $image = null)
    {
        $this->imageFileBannerPC = $image;

        if ($image) {
            $this->updated = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $image
     *
     * @return HomeSliderImages
     */
    public function setImageFileBannerMobile(File $image = null)
    {
        $this->imageFileBannerMobile = $image;

        if ($image) {
            $this->updated = new \DateTimeImmutable();
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getImageFileIconNoHover()
    {
        return $this->imageFileIconNoHover;
    }

    /**
     * @return File|null
     */
    public function getImageFileIconOnHover()
    {
        return $this->imageFileIconOnHover;
    }

    /**
     * @return File|null
     */
    public function getImageFileBannerPC()
    {
        return $this->imageFileBannerPC;
    }

    /**
     * @return File|null
     */
    public function getImageFileBannerMobile()
    {
        return $this->imageFileBannerMobile;
    }

    /**
     * @param string $imageNameIconNoHover
     *
     * @return HomeSliderImages
     */
    public function setImageNameIconNoHover($imageNameIconNoHover)
    {
        $this->imageNameIconNoHover = $imageNameIconNoHover;

        return $this;
    }

    /**
     * @param string $imageNameIconOnHover
     *
     * @return HomeSliderImages
     */
    public function setImageNameIconOnHover($imageNameIconOnHover)
    {
        $this->imageNameIconOnHover = $imageNameIconOnHover;

        return $this;
    }

    /**
     * @param string $imageNameBannerPC
     *
     * @return HomeSliderImages
     */
    public function setImageNameBannerPC($imageNameBannerPC)
    {
        $this->imageNameBannerPC = $imageNameBannerPC;

        return $this;
    }

    /**
     * @param string $imageNameBannerMobile
     *
     * @return HomeSliderImages
     */
    public function setImageNameBannerMobile($imageNameBannerMobile)
    {
        $this->imageNameBannerMobile = $imageNameBannerMobile;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getImageNameIconNoHover()
    {
        return $this->imageNameIconNoHover;
    }

    /**
     * @return string|null
     */
    public function getImageNameIconOnHover()
    {
        return $this->imageNameIconOnHover;
    }

    /**
     * @return string|null
     */
    public function getImageNameBannerPC()
    {
        return $this->imageNameBannerPC;
    }

    /**
     * @return string|null
     */
    public function getImageNameBannerMobile()
    {
        return $this->imageNameBannerMobile;
    }

    /**
     * @param integer $imageSizeIconNoHover
     *
     * @return HomeSliderImages
     */
    public function setImageSizeIconNoHover($imageSizeIconNoHover)
    {
        $this->imageSizeIconNoHover = $imageSizeIconNoHover;

        return $this;
    }

    /**
     * @param integer $imageSizeIconOnHover
     *
     * @return HomeSliderImages
     */
    public function setImageSizeIconOnHover($imageSizeIconOnHover)
    {
        $this->imageSizeIconOnHover = $imageSizeIconOnHover;

        return $this;
    }

    /**
     * @param integer $imageSizeBannerPC
     *
     * @return HomeSliderImages
     */
    public function setImageSizeBannerPC($imageSizeBannerPC)
    {
        $this->imageSizeBannerPC = $imageSizeBannerPC;

        return $this;
    }

    /**
     * @param integer $imageSizeBannerMobile
     *
     * @return HomeSliderImages
     */
    public function setImageSizeBannerMobile($imageSizeBannerMobile)
    {
        $this->imageSizeBannerMobile = $imageSizeBannerMobile;

        return $this;
    }

    /**
     * @return integer|null
     */
    public function getImageSizeIconNoHover()
    {
        return $this->imageSizeIconNoHover;
    }

    /**
     * @return integer|null
     */
    public function getImageSizeIconOnHover()
    {
        return $this->imageSizeIconNoHover;
    }

    /**
     * @return integer|null
     */
    public function getImageSizeBannerPC()
    {
        return $this->imageSizeIconNoHover;
    }

    /**
     * @return integer|null
     */
    public function getImageSizeBannerMobile()
    {
        return $this->imageSizeIconNoHover;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return strval($this->id);
    }
}