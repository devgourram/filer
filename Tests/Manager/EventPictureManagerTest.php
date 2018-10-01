<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Manager;

use Iad\Bundle\CoreBundle\Tests\Manager\AbstractManagerTrait;
use Iad\Bundle\CoreBundle\Tests\DoctrineMockTrait;
use Iad\Bundle\CoreBundle\Tests\PaginatorMockTrait;
use Iad\Bundle\FilerTechBundle\Manager\EventPictureManager;

/**
 * Class EventPictureManagerTest
 */
class EventPictureManagerTest extends \PHPUnit_Framework_TestCase
{
    use AbstractManagerTrait, DoctrineMockTrait, PaginatorMockTrait;

    /**
     * Test Mandate Manager
     */
    public function testAccessor()
    {
        $em = $this->buildEntityManagerMock();
        $paginator = $this->buildPaginatorMock();

        $manager = new EventPictureManager($em, $paginator);
        $this->addManagerTest($em, $manager, 'Iad\Bundle\FilerTechBundle\Entity\EventPicture', 'IadFilerTechBundle:EventPicture');
    }
}
