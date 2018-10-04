<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Business;

use Doctrine\ORM\EntityManager;
use Iad\Bundle\FilerTechBundle\Business\FilerFactory;
use Iad\Bundle\FilerTechBundle\Business\ImageManager;
use Iad\Bundle\FilerTechBundle\Business\Encoder;
use Iad\Bundle\FilerTechBundle\Business\Service\AvatarFiler;
use Symfony\Bundle\FrameworkBundle\Routing\Router;

/**
 * Class FilerFactoryTest
 *
 * @package Iad\Bundle\FilerTechBundle\Tests\Business
 */
class FilerFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * testAccessor
     */
    public function testAccessor()
    {
        $entityManager = $this->getMockBuilder(EntityManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $encoder = $this->getMockBuilder(Encoder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $imageManager = $this->getMockBuilder(ImageManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $router = $this->getMockBuilder(Router::class)
            ->disableOriginalConstructor()
            ->getMock();

        $fileFactory = new FilerFactory($encoder, $imageManager, $router);

        $this->assertInstanceOf(FilerFactory::class, $fileFactory);
        $this->assertEquals($imageManager, $fileFactory->getImageManager());
        $this->assertEquals($encoder, $fileFactory->getEncoder());

    }
}
