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
 * @ORM\MappedSuperclass
 *
 * Class PictureFile
 * @package Iad\Bundle\FilerTechBundle\Entity
 */
abstract class PictureFile implements PictureFileInterface
{
    use FilerTrait;
    use ImageTrait;

    /**
     * @var PictureInterface
     */
    protected $picture;

    public function setPicture(PictureInterface $picture)
    {
        $this->picture = $picture;
    }

    public function getPicture()
    {
        return $this->picture;
    }
}