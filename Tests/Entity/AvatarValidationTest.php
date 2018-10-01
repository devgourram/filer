<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Entity;

use Iad\Bundle\CoreBundle\Entity\Validation;
use Iad\Bundle\FilerTechBundle\Entity\Avatar;
use Iad\Bundle\FilerTechBundle\Entity\AvatarValidation;
use Iad\Bundle\TestBundle\Tests\AbstractTestCase;

/**
 * Class AvatarValidationTest
 *
 * @package Iad\Bundle\FilerTechBundle\Tests\Entity
 */
class AvatarValidationTest extends AbstractTestCase
{
    /**
     * Test all accessor
     */
    public function testAccessor()
    {
        $avatar = $this->prophesizeObject(Avatar::class)->reveal();
        $validation = $this->prophesizeObject(Validation::class)->reveal();

        $avatarValidation = new AvatarValidation($avatar, $validation);
        $className = AvatarValidation::class;

        $this->assertInstanceOf($className, $avatarValidation);
        $this->assertInstanceOf($className, $avatarValidation->setValue(true));
        $this->assertTrue($avatarValidation->getValue());

        $commentaire = uniqid();
        $this->assertInstanceOf($className, $avatarValidation->setComment($commentaire));
        $this->assertEquals($commentaire, $avatarValidation->getComment());
    }
}
