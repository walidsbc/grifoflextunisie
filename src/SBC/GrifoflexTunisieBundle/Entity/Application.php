<?php

namespace SBC\GrifoflexTunisieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * Application
 *
 * @ORM\Table(name="application")
 * @ORM\Entity(repositoryClass="SBC\GrifoflexTunisieBundle\Repository\ApplicationRepository")
 * @Vich\Uploadable
 */
class Application implements \JsonSerializable
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
     * @ORM\Column(name="requestType", type="string", length=255)
     */
    private $requestType;

    /**
     * @var string
     *
     * @ORM\Column(name="applicationType", type="string", length=255)
     */
    private $applicationType;

    /**
     * @var string
     *
     * @ORM\Column(name="fullName", type="string", length=255)
     */
    private $fullName;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="reference_offre", type="string", length=255, nullable=true)
     */
    private $referenceOffre;

    /**
     * @var string
     *
     * @ORM\Column(name="note", type="text", nullable=true)
     */
    private $note;

    /**
     * @Vich\UploadableField(mapping="application_cv", fileNameProperty="cvName")
     * @Assert\File(
     *     mimeTypes = {"image/png", "image/jpeg", "image/jpg", "image/gif","application/pdf", "application/x-pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"},
     *     mimeTypesMessage = "Please upload a valid PDF,IMAGE, our WORD"
     * )
     *
     * @var File
     */
    private $cvFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $cvName;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @Vich\UploadableField(mapping="application_motivation", fileNameProperty="motivationName")
     * @Assert\File(
     *     mimeTypes = {"image/png", "image/jpeg", "image/jpg", "image/gif","application/pdf", "application/x-pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document"},
     *     mimeTypesMessage = "Please upload a valid PDF,IMAGE, our WORD"
     * )
     *
     * @var File
     */
    private $motivationFile;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @var string
     */
    private $motivationName;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime")
     * @Assert\DateTime()
     */
    private $creationDate;



    function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function __construct()
    {
        $this->creationDate = new \Datetime();
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
     * Set requestType
     *
     * @param string $requestType
     *
     * @return Application
     */
    public function setRequestType($requestType)
    {
        $this->requestType = $requestType;

        return $this;
    }

    /**
     * Get requestType
     *
     * @return string
     */
    public function getRequestType()
    {
        return $this->requestType;
    }

    /**
     * Set applicationType
     *
     * @param string $applicationType
     *
     * @return Application
     */
    public function setApplicationType($applicationType)
    {
        $this->applicationType = $applicationType;

        return $this;
    }

    /**
     * Get applicationType
     *
     * @return string
     */
    public function getApplicationType()
    {
        return $this->applicationType;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return Application
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Application
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set note
     *
     * @param string $note
     *
     * @return Application
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $cvFile
     *
     * @return Application
     */
    public function setCvFile(File $cvFile = null)
    {
        $this->cvFile = $cvFile;

        if ($cvFile) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getCvFile()
    {
        return $this->cvFile;
    }

    /**
     *
     * @param string $cvName
     *
     * @return Application
     */
    public function setCvName($cvName)
    {
        $this->cvName = $cvName;
        return $this;
    }

    /**
     *
     * @return string|null
     */
    public function getCvName()
    {
        return $this->cvName;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Application
     */
    public function setUpdatedAt()
    {
        $this->updatedAt = new \DateTime('now');

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
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $motivationFile
     *
     * @return Application
     */
    public function setMotivationFile(File $motivationFile = null)
    {
        $this->motivationFile = $motivationFile;

        if ($motivationFile) {
            $this->updatedAt = new \DateTime('now');
        }

        return $this;
    }

    /**
     * @return File|null
     */
    public function getMotivationFile()
    {
        return $this->motivationFile;
    }

    /**
     *
     * @param string $motivationName
     *
     * @return Application
     */
    public function setMotivationName($motivationName)
    {
        $this->motivationName = $motivationName;
        return $this;
    }

    /**
     *
     * @return string|null
     */
    public function getMotivationName()
    {
        return $this->motivationName;
    }


    /**
     * Set referenceOffre
     *
     * @param string $referenceOffre
     *
     * @return Application
     */
    public function setReferenceOffre($referenceOffre)
    {
        $this->referenceOffre = $referenceOffre;

        return $this;
    }

    /**
     * Get referenceOffre
     *
     * @return string
     */
    public function getReferenceOffre()
    {
        return $this->referenceOffre;
    }

    /**
     * Set creationDate
     *
     * @param \DateTime $creationDate
     *
     * @return Application
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }
}

