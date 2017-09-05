<?php

namespace SBC\GrifoflexTunisieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContactMail
 *
 * @ORM\Table(name="contact_mail")
 * @ORM\Entity(repositoryClass="SBC\GrifoflexTunisieBundle\Repository\ContactMailRepository")
 */
class ContactMail
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
     * @return ContactMail
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

