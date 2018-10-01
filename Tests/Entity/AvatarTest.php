<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Iad\Bundle\CoreBundle\Entity\Validation;
use Iad\Bundle\FilerTechBundle\Entity\Avatar;
use Iad\Bundle\FilerTechBundle\Entity\AvatarFile;
use Iad\Bundle\FilerTechBundle\Entity\AvatarValidation;
use Iad\Bundle\TestBundle\Tests\AbstractTestCase;

/**
 * Class DocumentObjectTest
 * @package Iad\Bundle\FilerTechBundle\Tests\Entity
 */
class AvatarTest extends AbstractTestCase
{
    /**
     * Test all accessor
     */
    public function testAccessor()
    {
        $avatar             = new Avatar();
        $now                = new \DateTime();
        $avatarFile         = new AvatarFile();
        $avatarCollection   = new ArrayCollection();
        $className          = Avatar::class;

        $avatarCollection->add($avatarFile);

        $this->assertNull($avatar->getId());

        $this->assertSame($avatar, $avatar->setStatus('enabled'));
        $this->assertEquals('enabled', $avatar->getStatus());

        $this->assertSame($avatar, $avatar->setCreatedAt($now));
        $this->assertEquals($now, $avatar->getCreatedAt());

        $this->assertSame($avatar, $avatar->setUpdatedAt($now));
        $this->assertEquals($now, $avatar->getUpdatedAt());

        $this->assertSame($avatar, $avatar->addAvatarFile($avatarFile));
        $this->assertEquals($avatarCollection, $avatar->getAvatarFiles());

        $this->assertSame($avatar, $avatar->removeAvatarFile($avatarFile));
        $this->assertEmpty($avatar->getAvatarFiles());

        $validation = $this->prophesizeObject(Validation::class)->reveal();
        $validation2 = $this->prophesizeObject(Validation::class)->reveal();
        $avatarValidation = $this->prophesizeObject(AvatarValidation::class, ['comment' => uniqid(), 'value' => true, 'validation' => $validation])->reveal();
        $avatarValidations = new ArrayCollection([$avatarValidation]);
        $this->assertInstanceOf($className, $avatar->setAvatarValidations($avatarValidations));
        $this->assertCount(1, $avatar->getAvatarValidations());
        $this->assertInstanceOf($className, $avatar->addValidation($validation2));
        $this->assertCount(2, $avatar->getAvatarValidations());
        $this->assertInstanceOf($className, $avatar->removeValidation($validation));
        $this->assertCount(1, $avatar->getAvatarValidations());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testBadStatus()
    {
        $avatar = new Avatar();
        $avatar->setStatus('unknow_status');
    }
}
