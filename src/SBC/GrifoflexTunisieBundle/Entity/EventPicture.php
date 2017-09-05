<?php

namespace SBC\GrifoflexTunisieBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * EventPicture
 *
 * @ORM\Table(name="event_picture")
 * @ORM\Entity(repositoryClass="SBC\GrifoflexTunisieBundle\Repository\EventPictureRepository")
 * @Vich\Uploadable
 */
class EventPicture extends Picture
{


    /**
     * @ORM\ManyToOne(targetEntity="SBC\GrifoflexTunisieBundle\Entity\Event", inversedBy="pictures")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id")
     */
    protected $event;

    public function __construct()
    {
        parent::__construct();
    }


    /**
     * Set event
     *
     * @param \SBC\GrifoflexTunisieBundle\Entity\Event $event
     *
     * @return EventPicture
     */
    public function setEvent( $event = null)
    {
        $this->event = $event;

        return $this;
    }

    /**
     * Get event
     *
     * @return \SBC\GrifoflexTunisieBundle\Entity\Event
     */
    public function getEvent()
    {
        return $this->event;
    }

}

