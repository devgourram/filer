<?php

namespace Iad\Bundle\FilerTechBundle\Tests\Business\Filters;

use Iad\Bundle\FilerTechBundle\Business\Filters\CropParameters;

/**
 * Class AvatarFilerTest
 *
 * @package Iad\Bundle\FilerTechBundle\Tests\Business
 */
class CropParametersTest extends \PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testAccessor()
    {

        $cropParameters = new CropParameters();

        $this->assertSame($cropParameters, $cropParameters->setSize(42, 42));
        $this->assertEquals([42, 42], $cropParameters->getSize());

        $this->assertEquals($cropParameters, $cropParameters->setStart(142, 142));
        $this->assertEquals([142, 142], $cropParameters->getStart());

        $this->assertEquals($cropParameters, $cropParameters->setFilter('filterName'));
        $this->assertEquals('filterName', $cropParameters->getFilter());

        $config = [
            'filters' => [
                'crop' => [
                    'size' => [42, 42],
                    'start' => [142, 142],
                ],
            ],
        ];
        $this->assertEquals($config, $cropParameters->getFilterRuntimeConfig());
    }
}
