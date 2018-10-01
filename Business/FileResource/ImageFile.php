<?php

namespace Iad\Bundle\FilerTechBundle\Business\FileResource;

use JMS\Serializer\Annotation as JMS;

/**
 * Class    ImageFile
 *
 * @package Iad\Bundle\FilerTechBundle\Business\FileResource
 *
 * @JMS\ExclusionPolicy("all")
 */
class ImageFile extends File
{
    /**
     * @var integer $width
     *
     * @JMS\Expose()
     * @JMS\Groups({"metadata"})
     */
    protected $width;

    /**
     * @var integer $height
     *
     * @JMS\Expose()
     * @JMS\Groups({"metadata"})
     */
    protected $height;

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
     * @return File
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

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
     * @return File
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }
}
