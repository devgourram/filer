<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Business\Service;

use Gaufrette\Filesystem;
use Iad\Bundle\FilerTechBundle\Config\Configuration;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use phpmock\MockBuilder;
use Iad\Bundle\FilerTechBundle\Business\Encoder;
use Iad\Bundle\FilerTechBundle\Business\Service\DocumentFiler;
use Iad\Bundle\FilerTechBundle\Entity\BaseDocument;

/**
 * Class DocumentFilerTest
 *
 * @package Iad\Bundle\FilerTechBundle\Tests\Business
 */
class DocumentFilerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * testAccessor
     */
    public function testAccessor()
    {
        $this->assertTrue(class_exists('Iad\Bundle\FilerTechBundle\Business\Service\DocumentFiler'));
    }

    /**
     * testCreateSuccess
     */
    public function testCreateSuccess()
    {
        $documentFiler = $this->getDocumentFiler($this->getMockFilesystem());
        $idPeople = -1;
        $file = $this->getMockUploadedFile();

        /**
         * Document $document
         */
        $document = new BaseDocument();
        $document->setOriginalFile($file);

        $builder = new MockBuilder();
        $builder->setNamespace('Iad\Bundle\FilerTechBundle\Business')
            ->setName("file_get_contents")
            ->setFunction(
                function () {
                    return "this is a content";
                }
            );

        $mock = $builder->build();
        $mock->enable();

        $sObject = $documentFiler->create($document, $idPeople);

        $this->assertInstanceOf(BaseDocument::class, $sObject);
    }

    /**
     * @param Filesystem $filesystem
     *
     * @return DocumentFiler
     */
    private function getDocumentFiler(Filesystem $filesystem)
    {
        $encoder = new Encoder();
        $filer = new DocumentFiler($encoder);
        $filer->setPublicFilesystem($filesystem);
        $filer->setPrivateFilesystem($filesystem);


        $config = [BaseDocument::class => Configuration::createConfiguration([
            'class' => BaseDocument::class,
            'document_type' => 'document',
            'directory_prefix' => 'document/'
        ])];

        $filer->setConfiguration($config);

        return $filer;
    }

    /**
     * @return Filesystem
     */
    private function getMockFilesystem()
    {
        $filesystem = $this
            ->getMockBuilder(Filesystem::class)
            ->disableOriginalConstructor()
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
     * @return UploadedFile
     */
    private function getMockUploadedFile()
    {
        $object = $this->getMockBuilder(UploadedFile::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $object;
    }
}
