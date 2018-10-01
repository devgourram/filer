<?php

namespace Iad\Bundle\FilerTechBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Iad\Bundle\FilerTechBundle\Entity\Traits\FilerTrait;
use Iad\Bundle\FilerTechBundle\Entity\Traits\ImageTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="filer_realestate_picture_file")
 */
class RealEstatePictureFile
{
    use FilerTrait;
    use ImageTrait;
    use TimestampableEntity;

    /**
     * @var RealEstatePicture $realEstatePicture
     * @ORM\ManyToOne(targetEntity="Iad\Bundle\FilerTechBundle\Entity\RealEstatePicture", inversedBy="files")
     * @ORM\JoinColumn(name="id_realestate_picture", referencedColumnName="id", nullable=false, onDelete="cascade")
     */
    protected $realEstatePicture;

    /**
     * Set realEstatePicture
     *
     * @param  RealEstatePicture $realEstatePicture
     * @return RealEstatePictureFile
     */
    public function setRealEstatePicture(RealEstatePicture $realEstatePicture)
    {
        $this->realEstatePicture = $realEstatePicture;

        return $this;
    }

    /**
     * Get realEstatePicture
     *
     * @return RealEstatePicture
     */
    public function getRealEstatePicture()
    {
        return $this->realEstatePicture;
    }
}
