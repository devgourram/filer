<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Iad\Bundle\FilerTechBundle\Entity\RealEstatePicture;
use Iad\Bundle\FilerTechBundle\Entity\RealEstatePictureFile;

/**
 * Class DocumentObjectTest
 * @package Iad\Bundle\FilerTechBundle\Tests\Entity
 */
class RealEstatePictureTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test all accessor
     */
    public function testAccessor()
    {
        $realEstatePicture     = new RealEstatePicture();
        $realEstatePictureFile = new RealEstatePictureFile();
        $pictureCollection     = new ArrayCollection();
        $now                   = new \DateTime();
        $rank                  = 0;

        $pictureCollection->add($realEstatePictureFile);

        $this->assertNull($realEstatePicture->getId());

        $this->assertSame($realEstatePicture, $realEstatePicture->setCreatedAt($now));
        $this->assertEquals($now, $realEstatePicture->getCreatedAt());

        $this->assertSame($realEstatePicture, $realEstatePicture->setUpdatedAt($now));
        $this->assertEquals($now, $realEstatePicture->getUpdatedAt());

        $this->assertSame($realEstatePicture, $realEstatePicture->setRank($rank));
        $this->assertEquals($rank, $realEstatePicture->getRank());

        $this->assertSame($realEstatePicture, $realEstatePicture->setFiles($pictureCollection));
        $this->assertEquals($pictureCollection, $realEstatePicture->getFiles());

        $this->assertSame($realEstatePicture, $realEstatePicture->removeFile($realEstatePictureFile));
        $this->assertEmpty($realEstatePicture->getFiles());

        $this->assertSame($realEstatePicture, $realEstatePicture->addFile($realEstatePictureFile));
        $this->assertEquals($pictureCollection, $realEstatePicture->getFiles());
    }

}
