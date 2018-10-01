<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Iad\Bundle\FilerTechBundle\Entity\TrainingPolePicture;
use Iad\Bundle\FilerTechBundle\Entity\TrainingPolePictureFile;

/**
 * Class TrainingPolePictureTest
 * @package Iad\Bundle\FilerTechBundle\Tests\Entity
 */
class TrainingPolePictureTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test all accessor
     */
    public function testAccessor()
    {
        $trainingPolePicture     = new TrainingPolePicture();
        $trainingPolePictureFile = new TrainingPolePictureFile();
        $pictureCollection     = new ArrayCollection();
        $now                   = new \DateTime();
        $rank                  = 0;

        $pictureCollection->add($trainingPolePictureFile);

        $this->assertNull($trainingPolePicture->getId());

        $this->assertSame($trainingPolePicture, $trainingPolePicture->setCreatedAt($now));
        $this->assertEquals($now, $trainingPolePicture->getCreatedAt());

        $this->assertSame($trainingPolePicture, $trainingPolePicture->setUpdatedAt($now));
        $this->assertEquals($now, $trainingPolePicture->getUpdatedAt());

        $this->assertSame($trainingPolePicture, $trainingPolePicture->setRank($rank));
        $this->assertEquals($rank, $trainingPolePicture->getRank());

        $this->assertSame($trainingPolePicture, $trainingPolePicture->setFiles($pictureCollection));
        $this->assertEquals($pictureCollection, $trainingPolePicture->getFiles());

        $this->assertSame($trainingPolePicture, $trainingPolePicture->removeFile($trainingPolePictureFile));
        $this->assertEmpty($trainingPolePicture->getFiles());

        $this->assertSame($trainingPolePicture, $trainingPolePicture->addFile($trainingPolePictureFile));
        $this->assertEquals($pictureCollection, $trainingPolePicture->getFiles());
    }

}
