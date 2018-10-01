<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Entity;

use Iad\Bundle\FilerTechBundle\Entity\DocumentObject;
use Iad\Bundle\FilerTechBundle\Entity\RealEstatePicture;
use Iad\Bundle\FilerTechBundle\Entity\RealEstatePictureFile;

/**
 * Class DocumentObjectTest
 * @package Iad\Bundle\FilerTechBundle\Tests\Entity
 */
class RealEstatePictureFileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test all accessor
     */
    public function testAccessor()
    {
        $realEstatePictureFile = new RealEstatePictureFile();
        $realEstatePicture     = new RealEstatePicture();
        $now                   = new \DateTime();
        $documentObject        = new DocumentObject();

        $this->assertNull($realEstatePictureFile->getId());

        $this->assertSame($realEstatePictureFile, $realEstatePictureFile->setRealEstatePicture($realEstatePicture));
        $this->assertEquals($realEstatePicture, $realEstatePictureFile->getRealEstatePicture());

        $this->assertSame($realEstatePictureFile, $realEstatePictureFile->setCreatedAt($now));
        $this->assertEquals($now, $realEstatePictureFile->getCreatedAt());

        $this->assertSame($realEstatePictureFile, $realEstatePictureFile->setUpdatedAt($now));
        $this->assertEquals($now, $realEstatePictureFile->getUpdatedAt());

        $this->assertSame($realEstatePictureFile, $realEstatePictureFile->setHeight(42));
        $this->assertEquals(42, $realEstatePictureFile->getHeight());

        $this->assertSame($realEstatePictureFile, $realEstatePictureFile->setWidth(142));
        $this->assertEquals(142, $realEstatePictureFile->getWidth());

        $this->assertSame($realEstatePictureFile, $realEstatePictureFile->setSizeName('name'));
        $this->assertEquals('name', $realEstatePictureFile->getSizeName());

        $this->assertSame($realEstatePictureFile, $realEstatePictureFile->setDocumentObject($documentObject));
        $this->assertEquals($documentObject, $realEstatePictureFile->getDocumentObject());
    }
}
