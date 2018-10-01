<?php

namespace Iad\Bundle\FilerTechBundle\Manager;

use Iad\Bundle\CoreBundle\Manager\AbstractPaginateManager;

/**
 * Class RealEstatePictureManager
 */
class RealEstatePictureManager extends AbstractPaginateManager
{
    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return 'Iad\Bundle\FilerTechBundle\Entity\RealEstatePicture';
    }

    /**
     * @return \Iad\Bundle\FilerTechBundle\Repository\RealEstatePictureRepository
     */
    public function getRepository()
    {
        return $this->entityManager->getRepository('IadFilerTechBundle:RealEstatePicture');
    }

    /**
     *
     * @param int $page          Numéro de la page
     * @param int $numberPerPage Nombre résultat par page
     *
     * @return \Iad\Bundle\CoreBundle\Paginator\PaginatorView
     */
    public function findAllPaginate($page = null, $numberPerPage = null)
    {
        $query = $this
            ->getRepository()
            ->createQueryBuilder('a')
            ->addOrderBy('a.id', 'ASC')
            ->getQuery();

        return $this->paginator->paginate($query, $page, $numberPerPage);
    }
}
