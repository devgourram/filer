<?php

namespace Iad\Bundle\FilerTechBundle\Business;

use Doctrine\ORM\EntityManager;
use Iad\Bundle\FilerTechBundle\Business\FileResource\FileBuilder;
use Iad\Bundle\FilerTechBundle\Business\Service\AdministrativeDocumentFiler;
use Iad\Bundle\FilerTechBundle\Business\Service\AvatarFiler;
use Iad\Bundle\FilerTechBundle\Business\Service\EventPictureFiler;
use Iad\Bundle\FilerTechBundle\Business\Service\TrainingPolePictureFiler;
use Iad\Bundle\FilerTechBundle\Business\Service\RealEstatePictureFiler;
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
     * @return AvatarFiler
     */
    public function createAvatarFiler()
    {
        $filer = new AvatarFiler($this->encoder);
        $filer->setImageManager($this->imageManager);

        return $filer;
    }

    /**
     * @return RealEstatePictureFiler
     */
    public function createRealEstatePictureFiler()
    {
        $filer = new RealEstatePictureFiler($this->encoder);
        $filer->setImageManager($this->imageManager);

        return $filer;
    }

    /**
     * @return EventPictureFiler
     */
    public function createEventPictureFiler()
    {
        $filer = new EventPictureFiler($this->encoder);
        $filer->setImageManager($this->imageManager);

        return $filer;
    }

    /**
     * @return TrainingPolePictureFiler
     */
    public function createTrainingPolePictureFiler()
    {
        $filer = new TrainingPolePictureFiler($this->encoder);
        $filer->setImageManager($this->imageManager);

        return $filer;
    }

    /**
     * @return AdministrativeDocumentFiler
     */
    public function createAdministrativeDocumentFiler()
    {
        $filer = new AdministrativeDocumentFiler($this->encoder);
        $filer->setRouter($this->router);

        return $filer;
    }
}
