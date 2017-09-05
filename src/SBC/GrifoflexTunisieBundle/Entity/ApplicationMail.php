<?php

namespace SBC\GrifoflexTunisieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ApplicationMail
 *
 * @ORM\Table(name="application_mail")
 * @ORM\Entity(repositoryClass="SBC\GrifoflexTunisieBundle\Repository\ApplicationMailRepository")
 */
class ApplicationMail
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
     * @ORM\Column(name="mailAddress", type="string", length=255, unique=true)
     */
    private $mailAddress;


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
     * Set mailAddress
     *
     * @param string $mailAddress
     *
     * @return ApplicationMail
     */
    public function setMailAddress($mailAddress)
    {
        $this->mailAddress = $mailAddress;

        return $this;
    }

    /**
     * Get mailAddress
     *
     * @return string
     */
    public function getMailAddress()
    {
        return $this->mailAddress;
    }
}

