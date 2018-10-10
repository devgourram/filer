<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Iad\Bundle\FilerTechBundle\Entity\BasePicture;
use Iad\Bundle\FilerTechBundle\Entity\BasePictureFile;

/**
 * Class BasePictureTest
 * @package Iad\Bundle\FilerTechBundle\Tests\Entity
 */
class BasePictureTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test all accessor
     */
    public function testAccessor()
    {


        $picture               = $this->getMockBuilder(BasePicture::class)->getMockForAbstractClass();
        $pictureFile           = $this->getMockBuilder(BasePictureFile::class)->getMockForAbstractClass();
        $pictureCollection     = new ArrayCollection();
        $now                   = new \DateTime();
        $rank                  = 0;

        $pictureCollection->add($pictureFile);

        $this->assertNull($picture->getId());

        $this->assertSame($picture, $picture->setCreatedAt($now));
        $this->assertEquals($now, $picture->getCreatedAt());

        $this->assertSame($picture, $picture->setUpdatedAt($now));
        $this->assertEquals($now, $picture->getUpdatedAt());

        $this->assertSame($picture, $picture->setRank($rank));
        $this->assertEquals($rank, $picture->getRank());

        $this->assertSame($picture, $picture->setFiles($pictureCollection));
        $this->assertEquals($pictureCollection, $picture->getFiles());

        $this->assertSame($picture, $picture->removeFile($pictureFile));
        $this->assertEmpty($picture->getFiles());

        $this->assertSame($picture, $picture->addFile($pictureFile));
        $this->assertEquals($pictureCollection, $picture->getFiles());
    }

}
