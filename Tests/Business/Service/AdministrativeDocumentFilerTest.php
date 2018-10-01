<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Business\Service;

use Gaufrette\Filesystem;
use Iad\Bundle\FilerTechBundle\Business\Service\AdministrativeDocumentFiler;
use Iad\Bundle\FilerTechBundle\Business\Encoder;
use Iad\Bundle\FilerTechBundle\Entity\AdministrativeDocument;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use phpmock\MockBuilder;

/**
 * Class AdministrativeDocumentFilerTest
 *
 * @package Iad\Bundle\FilerTechBundle\Tests\Business
 */
class AdministrativeDocumentFilerTest extends \PHPUnit_Framework_TestCase
{
    /**
     * testAccessor
     */
    public function testAccessor()
    {
        $this->assertTrue(class_exists('Iad\Bundle\FilerTechBundle\Business\Service\AdministrativeDocumentFiler'));
    }

    /**
     * testCreateSuccess
     */
    public function testCreateSuccess()
    {
        $admDocFiler = $this->getAdmDocFiler($this->getMockFilesystem());
        $idPeople = 42;
        $file = $this->getMockUploadedFile();
        $document = new AdministrativeDocument();
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

        $sObject = $admDocFiler->create($document, $idPeople);

        $this->assertInstanceOf(AdministrativeDocument::class, $sObject);
    }

    /**
     * @param Filesystem $filesystem
     *
     * @return AdministrativeDocumentFiler
     */
    private function getAdmDocFiler(Filesystem $filesystem)
    {
        $encoder = new Encoder();
        $filer = new AdministrativeDocumentFiler($encoder);
        $filer->setPublicFilesystem($filesystem);
        $filer->setPrivateFilesystem($filesystem);

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
