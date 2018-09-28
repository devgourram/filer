<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Business;

use Iad\Bundle\FilerTechBundle\Business\Encoder;

class EncoderTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessor()
    {
        $encoder = new Encoder();

        $this->assertEquals(hash('sha256', 'hash hash hash'), $encoder->hash('hash hash hash'));

        $uuid = $encoder->uuid('hash hash hash');
        usleep(1);
        $this->assertNotEquals($uuid, $encoder->uuid('hash hash hash'));
    }
}
