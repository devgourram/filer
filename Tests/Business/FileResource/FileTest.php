<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Business\FileResource;

use Iad\Bundle\FilerTechBundle\Business\FileResource\File;

class FileTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessor()
    {
        $document = new File();

        $className = 'Iad\Bundle\FilerTechBundle\Business\FileResource\File';

        $fileGaufrette = $this->getMockBuilder('Gaufrette\File')
            ->disableOriginalConstructor()
            ->getMock();

        $fileGaufrette
            ->method('getContent')
            ->willReturn('Content file');

        $this->assertInstanceOf($className, $document->setAccess('private'));
        $this->assertEquals('private', $document->getAccess());

        $this->assertInstanceOf($className, $document->setDetails(['detail' => 'not important']));
        $this->assertEquals(['detail' => 'not important'], $document->getDetails());

        $this->assertInstanceOf($className, $document->setSize(42));
        $this->assertEquals(42, $document->getSize());

        $this->assertInstanceOf($className, $document->setName('test.txt'));
        $this->assertEquals('test.txt', $document->getName());

        $this->assertInstanceOf($className, $document->setType('MAND'));
        $this->assertEquals('MAND', $document->getType());

        $this->assertNull($document->getContent());

        $this->assertInstanceOf($className, $document->setFile($fileGaufrette));
        $this->assertEquals($fileGaufrette, $document->getFile());

        $this->assertEquals('Content file', $document->getContent());

        $this->assertEquals(base64_encode('Content file'), $document->getBase64Content());

        $this->assertInstanceOf($className, $document->setContent('New content file'));

        $this->assertInstanceOf($className, $document->setUuid('abcd123546'));
        $this->assertEquals('abcd123546', $document->getUuid());

        $this->assertInstanceOf($className, $document->setHash(hash('sha256', 'test')));
        $this->assertEquals(hash('sha256', 'test'), $document->getHash());

        $this->assertInstanceOf($className, $document->setMimeType('text/plain'));
        $this->assertEquals('text/plain', $document->getMimeType());

        $this->assertInstanceOf($className, $document->setUrl('http://url.com'));
        $this->assertEquals('http://url.com', $document->getUrl());
    }
}
