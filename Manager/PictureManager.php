<?php
/**
 * Created by PhpStorm.
 * User: agourram
 * Date: 01/10/18
 * Time: 11:04
 */

namespace Iad\Bundle\FilerTechBundle\Manager;


use Iad\Bundle\CoreBundle\Manager\AbstractPaginateManager;

class PictureManager extends AbstractPaginateManager implements PictureManagerInterface
{

    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return 'Iad\Bundle\FilerTechBundle\Entity\Picture';
    }

    /**
     * @return \Iad\Bundle\FilerTechBundle\Repository\PictureRepository
     */
    public function getRepository()
    {
        return $this->entityManager->getRepository('IadFilerTechBundle:Picture');
    }

}