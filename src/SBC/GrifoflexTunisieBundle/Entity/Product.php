<?php

namespace SBC\GrifoflexTunisieBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="SBC\GrifoflexTunisieBundle\Repository\ProductRepository")
 * @Vich\Uploadable
 */
class Product implements \JsonSerializable
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
     * @Vich\UploadableField(mapping="technicalSheets", fileNameProperty="technicalSheetName")
     * @Assert\File(
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Please upload a valid PDF"
     * )
     *
     * @var File
     */
    private $technicalSheetFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $technicalSheetName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="SBC\GrifoflexTunisieBundle\Entity\Category")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;


    /**
     * @ORM\OneToMany(targetEntity="SBC\GrifoflexTunisieBundle\Entity\ProductPicture", mappedBy="product", cascade={"persist", "merge", "remove"})
     * @ORM\JoinColumn(name="product_picture_id", referencedColumnName="id")
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
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * @return Product
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
     * @param \SBC\GrifoflexTunisieBundle\Entity\ProductPicture $picture
     *
     * @return Product
     */
    public function addPicture(ProductPicture $picture)
    {
        $picture->setProduct($this);
        $this->pictures[] = $picture;

        return $this;
    }

    /**
     * Remove picture
     *
     * @param \SBC\GrifoflexTunisieBundle\Entity\ProductPicture $picture
     */
    public function removePicture(ProductPicture $picture)
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


    /**
     * Set category
     *
     * @param \SBC\GrifoflexTunisieBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(Category $category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \SBC\GrifoflexTunisieBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }



    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $technicalSheetFile
     *
     * @return Product
     */
    public function settechnicalSheetFile(File $technicalSheetFile = null)
    {
        $this->technicalSheetFile = $technicalSheetFile;

        if ($technicalSheetFile) {
            $this->updatedAt = new \DateTime('now', new \DateTimeZone('UTC'));
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getTechnicalSheetFile()
    {
        return $this->technicalSheetFile;
    }

    /**
     *
     * @param string $technicalSheetName
     *
     * @return Product
     */
    public function setTechnicalSheetName($technicalSheetName)
    {
        $this->technicalSheetName = $technicalSheetName;
        return $this;
    }

    /**
     *
     * @return string|null
     */
    public function getTechnicalSheetName()
    {
        return $this->technicalSheetName;
    }

}