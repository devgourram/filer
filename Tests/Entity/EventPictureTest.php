<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Iad\Bundle\FilerTechBundle\Entity\EventPicture;
use Iad\Bundle\FilerTechBundle\Entity\EventPictureFile;

/**
 * Class EventPictureTest
 * @package Iad\Bundle\FilerTechBundle\Tests\Entity
 */
class EventPictureTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test all accessor
     */
    public function testAccessor()
    {
        $eventPicture     = new EventPicture();
        $eventPictureFile = new EventPictureFile();
        $pictureCollection     = new ArrayCollection();
        $now                   = new \DateTime();
        $rank                  = 0;

        $pictureCollection->add($eventPictureFile);

        $this->assertNull($eventPicture->getId());

        $this->assertSame($eventPicture, $eventPicture->setCreatedAt($now));
        $this->assertEquals($now, $eventPicture->getCreatedAt());

        $this->assertSame($eventPicture, $eventPicture->setUpdatedAt($now));
        $this->assertEquals($now, $eventPicture->getUpdatedAt());

        $this->assertSame($eventPicture, $eventPicture->setRank($rank));
        $this->assertEquals($rank, $eventPicture->getRank());

        $this->assertSame($eventPicture, $eventPicture->setFiles($pictureCollection));
        $this->assertEquals($pictureCollection, $eventPicture->getFiles());

        $this->assertSame($eventPicture, $eventPicture->removeFile($eventPictureFile));
        $this->assertEmpty($eventPicture->getFiles());

        $this->assertSame($eventPicture, $eventPicture->addFile($eventPictureFile));
        $this->assertEquals($pictureCollection, $eventPicture->getFiles());
    }

}
