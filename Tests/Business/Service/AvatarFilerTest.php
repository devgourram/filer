<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Business\Service;

use Gaufrette\Filesystem;
use Iad\Bundle\CoreBundle\Manager\AbstractPaginateManager;
use Iad\Bundle\FilerTechBundle\Business\Service\AvatarFiler;
use Iad\Bundle\FilerTechBundle\Business\Encoder;
use Iad\Bundle\FilerTechBundle\Business\FileResource\File;
use Iad\Bundle\FilerTechBundle\Business\ImageManager;
use Iad\Bundle\FilerTechBundle\Entity\DocumentObject;
use Iad\Bundle\FilerTechBundle\Manager\AvatarManager;

/**
 * Class AvatarFilerTest
 *
 * @package Iad\Bundle\FilerTechBundle\Tests\Business
 */
class AvatarFilerTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testAccessor()
    {
        $idPeople        = 42;
        $filesystem    = $this->getMockFilesystem();
        $avatarFiler   = $this->getAvatarFiler($filesystem);
        $avatarManager = $this->getMockAvatarManager();

        $imageManager = $this
            ->getMockBuilder(ImageManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->assertSame($avatarFiler, $avatarFiler->setPublicFilesystem($filesystem));
        $this->assertEquals($filesystem, $avatarFiler->getPublicFilesystem());
        $this->assertEquals($filesystem, $avatarFiler->getFilesystem('public'));

        $this->assertSame($avatarFiler, $avatarFiler->setPrivateFilesystem($filesystem));
        $this->assertEquals($filesystem, $avatarFiler->getPrivateFilesystem());
        $this->assertEquals($filesystem, $avatarFiler->getFilesystem('private'));

        $this->assertSame($avatarFiler, $avatarFiler->setImageManager($imageManager));
        $this->assertEquals($imageManager, $avatarFiler->getImageManager());

        $this->assertSame($avatarFiler, $avatarFiler->setAvatarManager($avatarManager));
        $this->assertEquals($avatarManager, $avatarFiler->getAvatarManager());

        $file = $this
            ->getMockBuilder(File::class)
            ->disableOriginalConstructor()
            ->getMock()
        ;
        $file
            ->method('getAccess')
            ->willReturn('public')
            ;

        $this->assertInstanceOf(DocumentObject::class, $avatarFiler->createDocumentObject($file, $idPeople));
    }

    /**
     * @param $filesystem
     *
     * @return AvatarFiler
     */
    private function getAvatarFiler($filesystem)
    {
        $encoder = new Encoder();

        $avatarFiler = new AvatarFiler($encoder);
        $avatarFiler->setPublicFilesystem($filesystem);
        $avatarFiler->setPrivateFilesystem($filesystem);


        return $avatarFiler;
    }

    /**
     * @return Filesystem
     */
    private function getMockFilesystem()
    {
        $filesystem = $this->getMockBuilder(Filesystem::class)
            ->disableOriginalConstructor()
            ->setMethods(['size', 'write'])
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
     * @return AvatarManager
     */
    private function getMockAvatarManager()
    {
        $avatarManager = $this->getMockBuilder(AbstractPaginateManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $avatarManager;
    }
}
