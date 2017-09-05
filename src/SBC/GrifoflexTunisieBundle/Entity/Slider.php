<?php

namespace SBC\GrifoflexTunisieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Slider
 *
 * @ORM\Table(name="slider")
 * @ORM\Entity(repositoryClass="SBC\GrifoflexTunisieBundle\Repository\SliderRepository")
 * @Vich\Uploadable
 */
class Slider
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
     * @ORM\Column(name="title", type="string", length=255, unique=true)
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @Vich\UploadableField(mapping="pictures", fileNameProperty="mainPictureName")
     * @Assert\File(
     *     mimeTypes = {"image/png", "image/jpeg", "image/jpg"},
     *     mimeTypesMessage = "Please upload a valid IMAGE"
     * )
     *
     * @var File
     */
    private $mainPictureFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $mainPictureName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \Datetime('now', new \DateTimeZone('UTC'));
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
     * @return Slider
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Slider
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Slider
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
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $mainPictureFile
     *
     * @return Slider
     */
    public function setMainPictureFile(File $mainPictureFile = null)
    {
        $this->mainPictureFile = $mainPictureFile;

        if ($mainPictureFile) {
            $this->updatedAt = new \DateTime('now', new \DateTimeZone('UTC'));
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getMainPictureFile()
    {
        return $this->mainPictureFile;
    }

    /**
     *
     * @param string $mainPictureName
     *
     * @return Slider
     */
    public function setMainPictureName($mainPictureName)
    {
        $this->mainPictureName = $mainPictureName;
        return $this;
    }

    /**
     *
     * @return string|null
     */
    public function getMainPictureName()
    {
        return $this->mainPictureName;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Slider
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime('now', new \DateTimeZone('UTC'));

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}

