<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Entity;

use Iad\Bundle\FilerTechBundle\Entity\DocumentObject;
use Iad\Bundle\FilerTechBundle\Entity\EventPicture;
use Iad\Bundle\FilerTechBundle\Entity\EventPictureFile;

/**
 * Class EventPictureFileTest
 * @package Iad\Bundle\FilerTechBundle\Tests\Entity
 */
class EventPictureFileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test all accessor
     */
    public function testAccessor()
    {
        $eventPictureFile = new EventPictureFile();
        $eventPicture     = new EventPicture();
        $now                   = new \DateTime();
        $documentObject        = new DocumentObject();

        $this->assertNull($eventPictureFile->getId());

        $this->assertSame($eventPictureFile, $eventPictureFile->setEventPicture($eventPicture));
        $this->assertEquals($eventPicture, $eventPictureFile->getEventPicture());

        $this->assertSame($eventPictureFile, $eventPictureFile->setCreatedAt($now));
        $this->assertEquals($now, $eventPictureFile->getCreatedAt());

        $this->assertSame($eventPictureFile, $eventPictureFile->setUpdatedAt($now));
        $this->assertEquals($now, $eventPictureFile->getUpdatedAt());

        $this->assertSame($eventPictureFile, $eventPictureFile->setHeight(42));
        $this->assertEquals(42, $eventPictureFile->getHeight());

        $this->assertSame($eventPictureFile, $eventPictureFile->setWidth(142));
        $this->assertEquals(142, $eventPictureFile->getWidth());

        $this->assertSame($eventPictureFile, $eventPictureFile->setSizeName('name'));
        $this->assertEquals('name', $eventPictureFile->getSizeName());

        $this->assertSame($eventPictureFile, $eventPictureFile->setDocumentObject($documentObject));
        $this->assertEquals($documentObject, $eventPictureFile->getDocumentObject());
    }
}
