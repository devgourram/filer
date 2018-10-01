<?php

namespace Iad\Bundle\FilerTechBundle\Manager;

use Iad\Bundle\CoreBundle\Manager\AbstractPaginateManager;

/**
 * Class AdministrativeDocumentManager
 */
class AdministrativeDocumentManager extends AbstractPaginateManager
{
    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return 'Iad\Bundle\FilerTechBundle\Entity\AdministrativeDocument';
    }

    /**
     * @return \Iad\Bundle\FilerTechBundle\Repository\AdministrativeDocumentRepository
     */
    public function getRepository()
    {
        return $this->entityManager->getRepository('IadFilerTechBundle:AdministrativeDocument');
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
