<?php

namespace Iad\Bundle\FilerTechBundle\Manager;

use Iad\Bundle\CoreBundle\Manager\AbstractPaginateManager;
use Iad\Bundle\FilerTechBundle\Entity\Avatar;

/**
 * Class DocumentObjectManager
 *
 * @package Iad\Bundle\FilerTechBundle\Manager
 */
class AvatarManager extends AbstractPaginateManager
{
    /**
     * {@inheritDoc}
     */
    public function getClass()
    {
        return 'Iad\Bundle\FilerTechBundle\Entity\Avatar';
    }

    /**
     * {@inheritDoc}
     */
    public function getRepository()
    {
        return $this->entityManager->getRepository('IadFilerTechBundle:Avatar');
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

    /**
     *
     * @param string $status
     * @param int    $page          Numéro de la page
     * @param int    $numberPerPage Nombre résultat par page
     *
     * @return \Iad\Bundle\CoreBundle\Paginator\PaginatorView
     */
    public function findAllByStatusPaginate($status, $page = null, $numberPerPage = null)
    {
        $query = $this
            ->getRepository()
            ->createQueryBuilder('a')
            ->where('a.status = :status')
            ->setParameter('status', $status)
            ->addOrderBy('a.id', 'ASC')
            ->getQuery();

        return $this->paginator->paginate($query, $page, $numberPerPage);
    }

    /**
     * @param integer $peopleId
     *
     * @return Avatar
     */
    public function disabledCurrentAvatar($peopleId)
    {
        /** @var Avatar $enabledAvatar */
        $enabledAvatar = $this->getRepository()->findOneBy(['people' => $peopleId, 'status' => Avatar::STATUS_ENABLED]);
        if ($enabledAvatar) {
            $enabledAvatar->setStatus(Avatar::STATUS_DISABLED);
        }

        return $enabledAvatar;
    }
}
