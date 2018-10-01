<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Business\FileResource;

use Iad\Bundle\FilerTechBundle\Business\FileResource\File;
use Gaufrette\File as FileGaufrette;

/**
 * Class FileTest
 *
 * @package Iad\Bundle\FilerTechBundle\Tests\Business\FileResource
 */
class FileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * testConstructNotNull
     */
    public function testFile()
    {
        $document = new File();

        $this->baseTest($document);

        $this->assertSame($document, $document->setContent('Content file'));
        $this->assertEquals('Content file', $document->getContent());

        $this->assertEquals(base64_encode('Content file'), $document->getBase64Content());
    }

    /**
     * @param File $document
     */
    private function baseTest(File $document)
    {
        $this->assertSame($document, $document->setAccess('private'));
        $this->assertEquals('private', $document->getAccess());

        $this->assertSame($document, $document->setDetails(['detail' => 'not important']));
        $this->assertEquals(['detail' => 'not important'], $document->getDetails());

        $this->assertSame($document, $document->setSize(42));
        $this->assertEquals(42, $document->getSize());

        $this->assertSame($document, $document->setName('test.txt'));
        $this->assertEquals('test.txt', $document->getName());

        $this->assertSame($document, $document->setDocumentType('MAND'));
        $this->assertEquals('MAND', $document->getDocumentType());

        $this->assertSame($document, $document->setUuid('abcd123546'));
        $this->assertEquals('abcd123546', $document->getUuid());

        $this->assertSame($document, $document->setChecksum(hash('sha256', 'test')));
        $this->assertEquals(hash('sha256', 'test'), $document->getChecksum());

        $this->assertSame($document, $document->setMimeType('text/plain'));
        $this->assertEquals('text/plain', $document->getMimeType());

        $this->assertSame($document, $document->setUrl('http://url.com'));
        $this->assertEquals('http://url.com', $document->getUrl());

        $this->assertSame($document, $document->setWidth(42));
        $this->assertEquals(42, $document->getWidth());

        $this->assertSame($document, $document->setHeight(142));
        $this->assertEquals(142, $document->getHeight());
    }
}
