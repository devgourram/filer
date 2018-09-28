<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Business;

use Gaufrette\Filesystem;
use Iad\Bundle\FilerTechBundle\Business\AvatarFiler;
use Iad\Bundle\FilerTechBundle\Business\Encoder;
use Iad\Bundle\FilerTechBundle\Business\FileResource\File;
use Iad\Bundle\FilerTechBundle\Manager\DocumentObjectManager;

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
        $encoder = new Encoder();

        $filesystem = $this->getMockBuilder(Filesystem::class)
            ->disableOriginalConstructor()
            ->getMock();

        $filesystem
            ->method('size')
            ->willReturn(42);
        $filesystem
            ->method('write')
            ->willReturn(42);

        $avatarFiler = new AvatarFiler($encoder);
        $avatarFiler->setPublicFilesystem($filesystem);
        $avatarFiler->setPrivateFilesystem($filesystem);

        $documentManager = $this
            ->getMockBuilder(DocumentObjectManager::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->assertSame($avatarFiler, $avatarFiler->setPublicFilesystem($filesystem));
        $this->assertEquals($filesystem, $avatarFiler->getPublicFilesystem());
        $this->assertEquals($filesystem, $avatarFiler->getFilesystem('public'));

        $this->assertSame($avatarFiler, $avatarFiler->setPrivateFilesystem($filesystem));
        $this->assertEquals($filesystem, $avatarFiler->getPrivateFilesystem());
        $this->assertEquals($filesystem, $avatarFiler->getFilesystem('private'));

        $this->assertSame($avatarFiler, $avatarFiler->setDocumentObjectManager($documentManager));
        $this->assertEquals($documentManager, $avatarFiler->getDocumentObjectManager());

        $file = $this
            ->getMockBuilder(File::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->assertInstanceOf(\Gaufrette\File::class, $avatarFiler->createFileGaufrette($file, 'private'));
    }
}
