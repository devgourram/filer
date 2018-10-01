<?php

namespace Iad\Bundle\FilerTechBundle\Manager;

use Iad\Bundle\CoreBundle\Manager\AbstractManager;
use Iad\Bundle\FilerTechBundle\Entity\EventPicture;

/**
 * Class EventPictureManager
 */
class EventPictureManager extends AbstractManager
{
    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return EventPicture::class;
    }

    /**
     * @return \Iad\Bundle\FilerTechBundle\Repository\EventPictureRepository
     */
    public function getRepository()
    {
        return $this->entityManager->getRepository('IadFilerTechBundle:EventPicture');
    }
}
