<?php

namespace SBC\GrifoflexTunisieBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity(repositoryClass="SBC\GrifoflexTunisieBundle\Repository\EventRepository")
 * @Vich\Uploadable
 */
class Event
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
     * @var \DateTime
     *
     * @ORM\Column(name="event_date", type="datetime")
     */
    private $eventDate;

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


    /**
     * @ORM\OneToMany(targetEntity="SBC\GrifoflexTunisieBundle\Entity\EventPicture", mappedBy="event", cascade={"persist", "merge", "remove"})
     * @ORM\JoinColumn(name="event_picture_id", referencedColumnName="id")
     * @Assert\Valid()
     */

    private $pictures;


    function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function __construct()
    {
        $this->createdAt = new \Datetime('now', new \DateTimeZone('UTC'));
        $this->pictures = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
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
     * @return Event
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
     * @return Event
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
     * Set eventDate
     *
     * @param \DateTime $eventDate
     *
     * @return Event
     */
    public function setEventDate($eventDate)
    {
        $this->eventDate = $eventDate;

        return $this;
    }

    /**
     * Get eventDate
     *
     * @return \DateTime
     */
    public function getEventDate()
    {
        return $this->eventDate;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Event
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
     * @return Event
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
     * @return Event
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
     * @return Event
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


    /**
     * Add picture
     *
     * @param \SBC\GrifoflexTunisieBundle\Entity\EventPicture $picture
     *
     * @return Event
     */
    public function addPicture(EventPicture $picture)
    {
        $picture->setEvent($this);
        $this->pictures[] = $picture;

        return $this;
    }

    /**
     * Remove picture
     *
     * @param \SBC\GrifoflexTunisieBundle\Entity\EventPicture $picture
     */
    public function removePicture(EventPicture $picture)
    {
        $this->pictures->removeElement($picture);
    }

    /**
     * Get pictures
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPictures()
    {
        return $this->pictures;
    }

}

