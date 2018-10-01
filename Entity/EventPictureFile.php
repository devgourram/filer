<?php

namespace Iad\Bundle\FilerTechBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Iad\Bundle\FilerTechBundle\Entity\Traits\FilerTrait;
use Iad\Bundle\FilerTechBundle\Entity\Traits\ImageTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="filer_event_picture_file")
 */
class EventPictureFile
{
    use FilerTrait;
    use ImageTrait;
    use TimestampableEntity;

    /**
     * @var EventPicture $eventPicture
     * @ORM\ManyToOne(targetEntity="Iad\Bundle\FilerTechBundle\Entity\EventPicture", inversedBy="files")
     * @ORM\JoinColumn(name="id_event_picture", referencedColumnName="id", nullable=false, onDelete="cascade")
     */
    protected $eventPicture;

    /**
     * Set eventPicture
     *
     * @param  EventPicture $eventPicture
     * @return EventPictureFile
     */
    public function setEventPicture(EventPicture $eventPicture)
    {
        $this->eventPicture = $eventPicture;

        return $this;
    }

    /**
     * Get eventPicture
     *
     * @return EventPicture
     */
    public function getEventPicture()
    {
        return $this->eventPicture;
    }
}
