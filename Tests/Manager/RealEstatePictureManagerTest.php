<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Manager;

use Iad\Bundle\CoreBundle\Tests\Manager\AbstractManagerTrait;
use Iad\Bundle\CoreBundle\Tests\DoctrineMockTrait;
use Iad\Bundle\CoreBundle\Tests\PaginatorMockTrait;
use Iad\Bundle\FilerTechBundle\Manager\RealEstatePictureManager;

/**
 * Class RealEstatePictureManagerTest
 */
class RealEstatePictureManagerTest extends \PHPUnit_Framework_TestCase
{
    use AbstractManagerTrait, DoctrineMockTrait, PaginatorMockTrait;

    /**
     * Test Mandate Manager
     */
    public function testAccessor()
    {
        $em = $this->buildEntityManagerMock();
        $paginator = $this->buildPaginatorMock();

        $manager = new RealEstatePictureManager($em, $paginator);
        $this->addManagerTest($em, $manager, 'Iad\Bundle\FilerTechBundle\Entity\RealEstatePicture', 'IadFilerTechBundle:RealEstatePicture');
    }
}
