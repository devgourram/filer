<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Business;

use Iad\Bundle\FilerTechBundle\Business\AvatarFiler;
use Iad\Bundle\FilerTechBundle\Business\FilerFactory;
use Iad\Bundle\FilerTechBundle\Manager\DocumentObjectManager;
use Iad\Bundle\FilerTechBundle\Business\Encoder;

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
        $encoder = $this->getMockBuilder(Encoder::class)
            ->disableOriginalConstructor()
            ->getMock();

        $documentObjectManager = $this->getMockBuilder(DocumentObjectManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $fileFactory = new FilerFactory($documentObjectManager, $encoder);
        $avatarFiler = $fileFactory->createAvatarFiler();

        $this->assertInstanceOf(AvatarFiler::class, $avatarFiler);
        $this->assertEquals($documentObjectManager, $avatarFiler->getDocumentObjectManager());
        $this->assertEquals($encoder, $avatarFiler->getEncoder());
    }
}
