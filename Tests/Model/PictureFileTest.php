<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Model;

use Iad\Bundle\FilerTechBundle\Entity\DocumentObject;
use Iad\Bundle\FilerTechBundle\Model\Picture;
use Iad\Bundle\FilerTechBundle\Model\PictureFile;

/**
 * Class PictureFileTest
 * @package Iad\Bundle\FilerTechBundle\Tests\Entity
 */
class PictureFileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test all accessor
     */
    public function testAccessor()
    {
        $pictureFile           = $this->getMockBuilder(PictureFile::class)->getMockForAbstractClass();
        $picture               = $this->getMockBuilder(Picture::class)->getMockForAbstractClass();
        $now                   = new \DateTime();
        $documentObject        = new DocumentObject();

        $this->assertNull($pictureFile->getId());

        $this->assertSame($pictureFile, $pictureFile->setPicture($picture));
        $this->assertEquals($picture, $pictureFile->getPicture());

        $this->assertSame($pictureFile, $pictureFile->setCreatedAt($now));
        $this->assertEquals($now, $pictureFile->getCreatedAt());

        $this->assertSame($pictureFile, $pictureFile->setUpdatedAt($now));
        $this->assertEquals($now, $pictureFile->getUpdatedAt());

        $this->assertSame($pictureFile, $pictureFile->setHeight(42));
        $this->assertEquals(42, $pictureFile->getHeight());

        $this->assertSame($pictureFile, $pictureFile->setWidth(142));
        $this->assertEquals(142, $pictureFile->getWidth());

        $this->assertSame($pictureFile, $pictureFile->setSizeName('name'));
        $this->assertEquals('name', $pictureFile->getSizeName());

        $this->assertSame($pictureFile, $pictureFile->setDocumentObject($documentObject));
        $this->assertEquals($documentObject, $pictureFile->getDocumentObject());
    }
}
