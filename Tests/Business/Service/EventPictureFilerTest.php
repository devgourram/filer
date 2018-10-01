<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Business\Service;

use Gaufrette\Filesystem;
use Iad\Bundle\FilerTechBundle\Business\Service\AvatarFiler;
use Iad\Bundle\FilerTechBundle\Business\Encoder;
use Iad\Bundle\FilerTechBundle\Business\FileResource\File;
use Iad\Bundle\FilerTechBundle\Business\ImageManager;
use Iad\Bundle\FilerTechBundle\Business\Service\EventPictureFiler;
use Iad\Bundle\FilerTechBundle\Entity\DocumentObject;
use Iad\Bundle\FilerTechBundle\Manager\AvatarManager;
use Iad\Bundle\FilerTechBundle\Manager\EventPictureManager;
use Liip\ImagineBundle\Binary\BinaryInterface;
use Liip\ImagineBundle\Model\Binary;

/**
 * Class EventPictureFilerTest
 *
 * @package Iad\Bundle\FilerTechBundle\Tests\Business\Service
 */
class EventPictureFilerTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testAccessor()
    {
        $idPeople = 42;
        $filesystem = $this->getMockFilesystem();
        $eventPictureFiler = $this->getEventPictureFiler($filesystem);
        $eventPictureManager = $this->getMockEventpictureManager();

        $imageManager = $this
            ->getMockBuilder(ImageManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->assertSame($eventPictureFiler, $eventPictureFiler->setPublicFilesystem($filesystem));
        $this->assertEquals($filesystem, $eventPictureFiler->getPublicFilesystem());
        $this->assertEquals($filesystem, $eventPictureFiler->getFilesystem('public'));

        $this->assertSame($eventPictureFiler, $eventPictureFiler->setPrivateFilesystem($filesystem));
        $this->assertEquals($filesystem, $eventPictureFiler->getPrivateFilesystem());
        $this->assertEquals($filesystem, $eventPictureFiler->getFilesystem('private'));

        $this->assertSame($eventPictureFiler, $eventPictureFiler->setImageManager($imageManager));
        $this->assertEquals($imageManager, $eventPictureFiler->getImageManager());

        $this->assertSame($eventPictureFiler, $eventPictureFiler->setEventPictureManager($eventPictureManager));
        $this->assertEquals($eventPictureManager, $eventPictureFiler->getEventPictureManager());

        $file = $this
            ->getMockBuilder(File::class)
            ->disableOriginalConstructor()
            ->getMock();
        $file
            ->method('getAccess')
            ->willReturn('public');

        $this->assertInstanceOf(DocumentObject::class, $eventPictureFiler->createDocumentObject($file, $idPeople));
    }

    /**
     * @param $filesystem
     *
     * @return EventPictureFiler
     */
    private function getEventPictureFiler($filesystem)
    {
        $encoder = new Encoder();

        $eventPictureFiler = new EventPictureFiler($encoder);
        $eventPictureFiler->setPublicFilesystem($filesystem);
        $eventPictureFiler->setPrivateFilesystem($filesystem);


        return $eventPictureFiler;
    }

    /**
     * @return Filesystem
     */
    private function getMockFilesystem()
    {
        $filesystem = $this->getMockBuilder(Filesystem::class)
                           ->disableOriginalConstructor()
                           ->setMethods(['write', 'size'])
                           ->getMock();
        $filesystem
            ->method('size')
            ->willReturn(42);
        $filesystem
            ->method('write')
            ->willReturn(42);

        return $filesystem;
    }

    /**
     * @return EventPictureManager
     */
    private function getMockEventpictureManager()
    {
        $eventPictureManager = $this->getMockBuilder(EventPictureManager::class)
                                    ->disableOriginalConstructor()
                                    ->getMock();

        return $eventPictureManager;
    }
}
