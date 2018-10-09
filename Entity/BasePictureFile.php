<?php
/**
 * Created by PhpStorm.
 * User: agourram
 * Date: 01/10/18
 * Time: 10:44
 */

namespace Iad\Bundle\FilerTechBundle\Entity;

use Gedmo\Timestampable\Traits\TimestampableEntity;
use Iad\Bundle\FilerTechBundle\Entity\Traits\FilerTrait;
use Iad\Bundle\FilerTechBundle\Entity\Traits\ImageTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="discr", type="string")
 * @ORM\DiscriminatorMap({})
 */
abstract class BasePictureFile implements PictureFileInterface
{
    use FilerTrait;
    use ImageTrait;
    use TimestampableEntity;
	

    /**
     * @var PictureInterface
     *
     * @ORM\ManyToOne(targetEntity="BasePicture", inversedBy="files", cascade={"persist"})
     */
    protected $picture;

    public function setPicture(PictureInterface $picture)
    {
        $this->picture = $picture;
        return $this;
    }

    public function getPicture()
    {
        return $this->picture;
    }
}