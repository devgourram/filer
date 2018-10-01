<?php

namespace Iad\Bundle\FilerTechBundle\Manager;

use Iad\Bundle\CoreBundle\Manager\AbstractPaginateManager;

/**
 * Class DocumentObjectManager
 *
 * @package Iad\Bundle\FilerTechBundle\Manager
 */
class DocumentObjectManager extends AbstractPaginateManager
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
            ->createQueryBuilder('d')
            ->addOrderBy('d.id', 'ASC')
            ->getQuery();

        return $this->paginator->paginate($query, $page, $numberPerPage);
    }

    /**
     *
     * @param string $documentType
     * @param int    $page          Numéro de la page
     * @param int    $numberPerPage Nombre résultat par page
     *
     * @return \Iad\Bundle\CoreBundle\Paginator\PaginatorView
     */
    public function findAllByDocumentTypePaginate($documentType, $page = null, $numberPerPage = null)
    {
        $query = $this
            ->getRepository()
            ->createQueryBuilder('d')
            ->where('d.documentType = :documentType')
            ->setParameter('documentType', $documentType)
            ->addOrderBy('d.id', 'ASC')
            ->getQuery();

        return $this->paginator->paginate($query, $page, $numberPerPage);
    }
}
