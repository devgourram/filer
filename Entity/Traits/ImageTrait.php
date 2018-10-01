<?php

namespace Iad\Bundle\FilerTechBundle\Entity\Traits;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class ImageTrait
 *
 * @package Iad\Bundle\FilerTechBundle\Entity\Traits
 */
trait ImageTrait
{
    public static $sizeNameSource = 'source';
    public static $sizeNameOriginal = 'original';

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $height;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    private $width;

    /**
     * @var string
     *
     * @Assert\Length(max="50")
     * @ORM\Column(name="size_name", type="string", length=50)
     */
    private $sizeName;

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * @param int $height
     *
     * @return $this
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @param int $width
     *
     * @return $this
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * @return string
     */
    public function getSizeName()
    {
        return $this->sizeName;
    }

    /**
     * @param string $sizeName
     *
     * @return $this
     */
    public function setSizeName($sizeName)
    {
        $this->sizeName = $sizeName;

        return $this;
    }
}
