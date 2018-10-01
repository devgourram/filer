<?php

namespace Iad\Bundle\FilerTechBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Iad\Bundle\FilerTechBundle\Entity\Traits\FilerTrait;
use Iad\Bundle\FilerTechBundle\Entity\Traits\ImageTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="filer_training_pole_picture_file")
 */
class TrainingPolePictureFile
{
    use FilerTrait;
    use ImageTrait;
    use TimestampableEntity;

    /**
     * @var TrainingPolePicture $trainingPolePicture
     * @ORM\ManyToOne(targetEntity="Iad\Bundle\FilerTechBundle\Entity\TrainingPolePicture", inversedBy="files")
     * @ORM\JoinColumn(name="id_training_pole_picture", referencedColumnName="id", nullable=false, onDelete="cascade")
     */
    protected $trainingPolePicture;

    /**
     * Set trainingPicture
     *
     * @param  TrainingPolePicture $trainingPolePicture
     * @return TrainingPolePictureFile
     */
    public function setTrainingPolePicture(TrainingPolePicture $trainingPolePicture)
    {
        $this->trainingPolePicture = $trainingPolePicture;

        return $this;
    }

    /**
     * Get trainingPolePicture
     *
     * @return TrainingPolePicture
     */
    public function getTrainingPolePicture()
    {
        return $this->trainingPolePicture;
    }
}
