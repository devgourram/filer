<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Entity;

use Iad\Bundle\FilerTechBundle\Entity\BaseDocument;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class BaseDocumentTest
 * @package Iad\Bundle\FilerTechBundle\Tests\Entity
 */
class BaseDocumentTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test all accessor
     */
    public function testAccessor()
    {
        $document = $this->getMockBuilder(BaseDocument::class)->getMockForAbstractClass();
        $uploadedFile     = $this->getUploadedFile();


        $this->assertNull($document->getId());

        $this->assertSame($document, $document->setOriginalFile($uploadedFile));
        $this->assertEquals($uploadedFile, $document->getOriginalFile());
    }

    /**
     * @return UploadedFile
     */
    private function getUploadedFile()
    {
        $uploadedFile = $this->getMockBuilder(UploadedFile::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $uploadedFile;
    }
}
