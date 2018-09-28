<?php

namespace Iad\Bundle\FilerTechBundle\Manager;

use Iad\Bundle\CoreBundle\Manager\AbstractManager;

/**
 * Class DocumentObjectManager
 * @package Iad\Bundle\FilerTechBundle\Manager
 */
class DocumentObjectManager extends AbstractManager
{
    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return 'Iad\Bundle\FilerTechBundle\Entity\DocumentObject';
    }

    /**
     * {@inheritDoc}
     */
    public function getRepository()
    {
        return $this->entityManager->getRepository('IadFilerTechBundle:DocumentObject');
    }

    /**
     * @param string $uuid
     * @return mixed
     */
    public function findOneByUuid($uuid)
    {
        return $this->getRepository()->findOneByUuid($uuid);
    }
}
