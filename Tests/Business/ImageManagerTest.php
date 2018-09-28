<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Business;

use Iad\Bundle\FilerTechBundle\Business\ImageManager;

class ImageManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testIsImage()
    {
        $filterManager = $this->buildFilterManagerMock();

        $manager = new ImageManager($filterManager);

        $this->assertTrue($manager->isImage('image/png'));
        $this->assertFalse($manager->isImage('text/plain'));

        $binary = $manager->createBinary('tata yoyo', 'image/png');

        $this->assertInstanceOf('Liip\ImagineBundle\Model\Binary', $binary);
        $this->assertEquals('tata yoyo', $binary->getContent());
        $this->assertEquals('image/png', $binary->getMimeType());
        $this->assertEquals('png', $binary->getFormat());
    }

    protected function buildFilterManagerMock()
    {
        $dataManager = $this->getMockBuilder('Liip\ImagineBundle\Imagine\Filter\FilterManager')
            ->disableOriginalConstructor()
            ->getMock();

        return $dataManager;
    }
}
