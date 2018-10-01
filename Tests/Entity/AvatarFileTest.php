<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Entity;

use Iad\Bundle\FilerTechBundle\Entity\Avatar;
use Iad\Bundle\FilerTechBundle\Entity\AvatarFile;
use Iad\Bundle\FilerTechBundle\Entity\DocumentObject;

/**
 * Class DocumentObjectTest
 * @package Iad\Bundle\FilerTechBundle\Tests\Entity
 */
class AvatarFileTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test all accessor
     */
    public function testAccessor()
    {
        $avatarFile     = new AvatarFile();
        $avatar         = new Avatar();
        $now            = new \DateTime();
        $documentObject = new DocumentObject();

        $this->assertNull($avatarFile->getId());

        $this->assertSame($avatarFile, $avatarFile->setAvatar($avatar));
        $this->assertEquals($avatar, $avatarFile->getAvatar());

        $this->assertSame($avatarFile, $avatarFile->setCreatedAt($now));
        $this->assertEquals($now, $avatarFile->getCreatedAt());

        $this->assertSame($avatarFile, $avatarFile->setUpdatedAt($now));
        $this->assertEquals($now, $avatarFile->getUpdatedAt());

        $this->assertSame($avatarFile, $avatarFile->setHeight(42));
        $this->assertEquals(42, $avatarFile->getHeight());

        $this->assertSame($avatarFile, $avatarFile->setWidth(142));
        $this->assertEquals(142, $avatarFile->getWidth());

        $this->assertSame($avatarFile, $avatarFile->setSizeName('name'));
        $this->assertEquals('name', $avatarFile->getSizeName());

        $this->assertSame($avatarFile, $avatarFile->setDocumentObject($documentObject));
        $this->assertEquals($documentObject, $avatarFile->getDocumentObject());
    }
}
