<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Business;

use Iad\Bundle\FilerTechBundle\Business\ResizeParameters;

class ResizeParametersTest extends \PHPUnit_Framework_TestCase
{
    public function testAccessor()
    {
        $params = new ResizeParameters();

        $className = 'Iad\Bundle\FilerTechBundle\Business\ResizeParameters';

        $this->assertNull($params->getFilter());
        $this->assertInstanceOf($className, $params->setFilter('high'));
        $this->assertEquals('high', $params->getFilter());

        $this->assertNull($params->getDisposition());
        $this->assertInstanceOf($className, $params->setDisposition('attachment'));
        $this->assertEquals('attachment', $params->getDisposition());

        $this->assertEquals('inset', $params->getMode());
        $this->assertInstanceOf($className, $params->setMode('outbound'));
        $this->assertEquals('outbound', $params->getMode());

        $this->assertEquals(70, $params->getQuality());
        $this->assertInstanceOf($className, $params->setQuality(80));
        $this->assertEquals(80, $params->getQuality());

        $this->assertEquals([], $params->getFilterRuntimeConfig());

        $this->assertNull($params->getSize());
        $this->assertInstanceOf($className, $params->setSize([360, 200]));
        $this->assertEquals([360, 200], $params->getSize());

        $runtimeConfig = $params->getFilterRuntimeConfig();

        $this->assertTrue(isset($runtimeConfig['quality']));
        $this->assertEquals($runtimeConfig['quality'], $params->getQuality());

        $this->assertTrue(isset($runtimeConfig['filters']['thumbnail']['size']));
        $this->assertEquals($runtimeConfig['filters']['thumbnail']['size'], $params->getSize());

        $this->assertTrue(isset($runtimeConfig['filters']['thumbnail']['mode']));
        $this->assertEquals($runtimeConfig['filters']['thumbnail']['mode'], $params->getMode());
    }
}
