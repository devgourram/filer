<?php

namespace Iad\Bundle\FilerTechBundle\Manager;

use Iad\Bundle\CoreBundle\Manager\AbstractManager;
use Iad\Bundle\FilerTechBundle\Entity\TrainingPolePicture;

/**
 * Class TrainingPolePictureManager
 */
class TrainingPolePictureManager extends AbstractManager
{
    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return TrainingPolePicture::class;
    }

    /**
     * @return \Iad\Bundle\FilerTechBundle\Repository\TrainingPolePictureRepository
     */
    public function getRepository()
    {
        return $this->entityManager->getRepository('IadFilerTechBundle:TrainingPolePicture');
    }
}
