<?php

namespace Iad\Bundle\FilerTechBundle\Business;

use Doctrine\ORM\EntityManager;
use Iad\Bundle\FilerTechBundle\Business\FileResource\FileBuilder;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class FilerFactory
 *
 * @package Iad\Bundle\FilerTechBundle\Business
 */
class FilerFactory
{
    /**
     * @var EntityManager $entityManager
     */
    protected $entityManager;

    /**
     * @var FileBuilder $fileBuilder
     */
    protected $fileBuilder;

    /**
     * @var Encoder $encoder
     */
    protected $encoder;

    /**
     * @var ImageManager $imageManager
     */
    protected $imageManager;

    /**
     * FilerFactory constructor.
     *
     * @param Encoder      $encoder
     * @param ImageManager $imageManager
     * @param Router       $router
     */
    public function __construct(Encoder $encoder, ImageManager $imageManager, Router $router)
    {
        $this->encoder      = $encoder;
        $this->imageManager = $imageManager;
        $this->router       = $router;
    }

    /**
     * @return EntityManager
     */
    public function getEntityManager()
    {
        return $this->entityManager;
    }

    /**
     * @param EntityManager $entityManager
     * @return FilerFactory
     */
    public function setEntityManager($entityManager)
    {
        $this->entityManager = $entityManager;
        return $this;
    }

    /**
     * @return FileBuilder
     */
    public function getFileBuilder()
    {
        return $this->fileBuilder;
    }

    /**
     * @param FileBuilder $fileBuilder
     * @return FilerFactory
     */
    public function setFileBuilder($fileBuilder)
    {
        $this->fileBuilder = $fileBuilder;
        return $this;
    }

    /**
     * @return Encoder
     */
    public function getEncoder()
    {
        return $this->encoder;
    }

    /**
     * @param Encoder $encoder
     * @return FilerFactory
     */
    public function setEncoder($encoder)
    {
        $this->encoder = $encoder;
        return $this;
    }

    /**
     * @return ImageManager
     */
    public function getImageManager()
    {
        return $this->imageManager;
    }

    /**
     * @param ImageManager $imageManager
     * @return FilerFactory
     */
    public function setImageManager($imageManager)
    {
        $this->imageManager = $imageManager;
        return $this;
    }
}
