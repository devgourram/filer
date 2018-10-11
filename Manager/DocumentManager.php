<?php
/**
 * Created by PhpStorm.
 * User: agourram
 * Date: 01/10/18
 * Time: 11:04
 */

namespace Iad\Bundle\FilerTechBundle\Manager;

use Iad\Bundle\CoreBundle\Manager\AbstractPaginateManager;

class DocumentManager extends AbstractPaginateManager implements DocumentManagerInterface
{

    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return 'Iad\Bundle\FilerTechBundle\Entity\Document';
    }

    /**
     * @return \Iad\Bundle\FilerTechBundle\Repository\DocumentRepository
     */
    public function getRepository()
    {
        return $this->entityManager->getRepository('IadFilerTechBundle:Document');
    }
}
