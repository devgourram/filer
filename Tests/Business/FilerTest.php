<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Business;

use Iad\Bundle\FilerTechBundle\Business\Filer;
use Iad\Bundle\FilerTechBundle\Business\ResizeParameters;

class FilerTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessor()
    {
        $filer = $this->buildFiler('high');

        $className = 'Iad\Bundle\FilerTechBundle\Business\Filer';

        $file = $this->buildFileMock('TEST', 42, 'text/plain');

        $this->assertInstanceOf($className, $filer->setDocumentTypes(['TEST']));
        $this->assertEquals(['TEST'], $filer->getDocumentTypes());

        $this->assertInstanceOf('Iad\Bundle\FilerTechBundle\Business\FileResource\FileBuilder', $filer->getFileBuilder());

        $this->assertInstanceOf($className, $filer->setFileMaxSize(23000));
        $this->assertInstanceOf($className, $filer->setImageMaxSize(4400));
        $this->assertInstanceOf($className, $filer->setDefaultImageFormat('png'));
        $this->assertInstanceOf($className, $filer->setDefaultImageFilter('high'));
        $this->assertInstanceOf($className, $filer->setMimeTypes(['text/plain']));

        $this->assertTrue($filer->checkFile($file));

        // Try to resize a text/plain
        $this->assertEquals($file, $filer->resize($file, new ResizeParameters()));
    }

    /**
     * @expectedException \Iad\Bundle\FilerTechBundle\Business\Exception\DocumentTypeException
     */
    public function testCheckFileTypeException()
    {
        $filer = $this->buildFiler('high');
        $filer->setDocumentTypes(['TEST']);

        $file = $this->buildFileMock('UNKNOWN', 1000000, 'text/plain');

        $filer->checkFile($file);
    }

    /**
     * @expectedException \Iad\Bundle\FilerTechBundle\Business\Exception\DocumentSizeException
     */
    public function testCheckFileSizeException()
    {
        $filer = $this->buildFiler('high');
        $filer->setDocumentTypes(['TEST']);
        $filer->setMimeTypes(['text/plain']);

        $file = $this->buildFileMock('TEST', 1000000, 'text/plain');

        $filer->checkFile($file);
    }

    /**
     * @expectedException \Iad\Bundle\FilerTechBundle\Business\Exception\DocumentMimeTypeException
     */
    public function testCheckMimeTypeException()
    {
        $filer = $this->buildFiler('high');
        $filer->setDocumentTypes(['TEST']);
        $filer->setMimeTypes(['image/png']);

        $file = $this->buildFileMock('TEST', 42, 'text/plain');

        $filer->checkFile($file);
    }

    protected function buildFiler($defaultImageSize, $isImage = false)
    {
        $encoder = $this->buildEncoderMock();
        $documentObjectManager = $this->buildDocumentObjectManagerMock();
        $imageManager = $this->buildImageManagerMock();
        $router = $this->buildRouterMock();
        $fileSystem = $this->buildFileSystem();

        $imageManager
            ->method('isImage')
            ->willReturn($isImage);

        $filer = new Filer(
            $encoder,
            $documentObjectManager,
            $imageManager,
            $router,
            $fileSystem,
            $defaultImageSize
        );

        return $filer;
    }

    protected function buildFileMock($documentType, $size, $mimeType)
    {
        $file = $this->getMockBuilder('Iad\Bundle\FilerTechBundle\Business\FileResource\File')
            ->disableOriginalConstructor()
            ->getMock();

        $file
            ->method('getType')
            ->willReturn($documentType);

        $file
            ->method('getSize')
            ->willReturn($size);

        $file
            ->method('getMimeType')
            ->willReturn($mimeType);

        $file
            ->method('setContent')
            ->willReturn($file);

        return $file;
    }

    protected function buildEncoderMock()
    {
        $encoder = $this->getMockBuilder('Iad\Bundle\FilerTechBundle\Business\Encoder')->getMock();

        return $encoder;
    }

    protected function buildDocumentObjectManagerMock()
    {
        $manager = $this->getMockBuilder('Iad\Bundle\FilerTechBundle\Manager\DocumentObjectManager')
            ->disableOriginalConstructor()
            ->getMock();

        return $manager;
    }

    protected function buildImageManagerMock()
    {
        $manager = $this->getMockBuilder('Iad\Bundle\FilerTechBundle\Business\ImageManager')
            ->disableOriginalConstructor()
            ->getMock();

        return $manager;
    }

    protected function buildRouterMock()
    {
        $manager = $this->getMockBuilder('Symfony\Component\Routing\Router')
            ->disableOriginalConstructor()
            ->getMock();

        return $manager;
    }

    protected function buildFileSystem()
    {
        $fileSystem = $this->getMockBuilder('Gaufrette\Filesystem')
            ->disableOriginalConstructor()
            ->getMock();

        return $fileSystem;
    }
}
