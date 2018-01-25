<?php

namespace Kuhni\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * ProjectImages
 * @Vich\Uploadable
 *
 * @ORM\Table(name="project_images")
 * @ORM\Entity(repositoryClass="Kuhni\Bundle\Repository\ProjectImagesRepository")
 */
class ProjectImages
{
    use TraitId;

    /**
     * @var Project
     *
     * @ORM\ManyToOne(targetEntity="Kuhni\Bundle\Entity\Project", cascade={"persist"})
     * @ORM\JoinColumn(name="project_id", referencedColumnName="id")
     */
    private $projectId;

    /**
     * @var string
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * Set projectId
     * @param integer $projectId
     * @return ProjectImages
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
        return $this;
    }

    /**
     * Get projectId
     * @return Project
     */
    public function getProjectId()
    {
        return $this->projectId;
    }

    /**
     * Set title
     * @param string $title
     * @return ProjectImages
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
     * @return ProjectImages
     */
    public function setUpdated(\DateTime $updated)
    {
        $this->updated = $updated;
        return $this;
    }

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @Vich\UploadableField(mapping="kuhni", fileNameProperty="imageName", size="imageSize")
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
     * @return ProjectImages
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
     * @return ProjectImages
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
     * @return ProjectImages
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