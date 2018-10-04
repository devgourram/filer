<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Iad\Bundle\FilerTechBundle\Model\Picture;
use Iad\Bundle\FilerTechBundle\Model\PictureFile;

/**
 * Class PictureTest
 * @package Iad\Bundle\FilerTechBundle\Tests\Entity
 */
class PictureTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test all accessor
     */
    public function testAccessor()
    {


        $picture               = $this->getMockBuilder(Picture::class)->getMockForAbstractClass();
        $pictureFile           = $this->getMockBuilder(PictureFile::class)->getMockForAbstractClass();
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
