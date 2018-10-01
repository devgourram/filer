<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Entity;

use Iad\Bundle\FilerTechBundle\Entity\DocumentObject;
use Iad\Bundle\FilerTechBundle\Entity\TrainingPolePicture;
use Iad\Bundle\FilerTechBundle\Entity\TrainingPolePictureFile;

/**
 * Class TrainingPolePictureFileTest
 * @package Iad\Bundle\FilerTechBundle\Tests\Entity
 */
class TrainingPolePictureFileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test all accessor
     */
    public function testAccessor()
    {
        $trainingPolePictureFile = new TrainingPolePictureFile();
        $trainingPolePicture     = new TrainingPolePicture();
        $now                   = new \DateTime();
        $documentObject        = new DocumentObject();

        $this->assertNull($trainingPolePictureFile->getId());

        $this->assertSame($trainingPolePictureFile, $trainingPolePictureFile->setTrainingPolePicture($trainingPolePicture));
        $this->assertEquals($trainingPolePicture, $trainingPolePictureFile->getTrainingPolePicture());

        $this->assertSame($trainingPolePictureFile, $trainingPolePictureFile->setCreatedAt($now));
        $this->assertEquals($now, $trainingPolePictureFile->getCreatedAt());

        $this->assertSame($trainingPolePictureFile, $trainingPolePictureFile->setUpdatedAt($now));
        $this->assertEquals($now, $trainingPolePictureFile->getUpdatedAt());

        $this->assertSame($trainingPolePictureFile, $trainingPolePictureFile->setHeight(42));
        $this->assertEquals(42, $trainingPolePictureFile->getHeight());

        $this->assertSame($trainingPolePictureFile, $trainingPolePictureFile->setWidth(142));
        $this->assertEquals(142, $trainingPolePictureFile->getWidth());

        $this->assertSame($trainingPolePictureFile, $trainingPolePictureFile->setSizeName('name'));
        $this->assertEquals('name', $trainingPolePictureFile->getSizeName());

        $this->assertSame($trainingPolePictureFile, $trainingPolePictureFile->setDocumentObject($documentObject));
        $this->assertEquals($documentObject, $trainingPolePictureFile->getDocumentObject());
    }
}
