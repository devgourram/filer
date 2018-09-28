<?php
namespace Iad\Bundle\FilerTechBundle\Tests\DependencyInjection;

use Iad\Bundle\FilerTechBundle\DependencyInjection\IadFilerTechExtension;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class IadFilerTechExtensionTest
 *
 * @package Iad\Bundle\FilerTechBundle\Tests\DependencyInjection
 */
class IadFilerTechExtensionTest extends \PHPUnit_Framework_TestCase
{
    /**
     * successConfigTest
     */
    public function testSuccessConfig()
    {
        $iadFilerTechExtension = new IadFilerTechExtension();

        $containerBuilder = $this->getContainerBuilderMock([
            'channels' => [
                'local' => [
                    'adapter'        => 'local',
                    'enable_public'  => true,
                    'enable_private' => true,
                    'public_path'    => '/tmp/public',
                    'private_path'   => '/tmp/public',
                ],
            ],
        ]);

        $containerBuilder
            ->expects($this->once())
            ->method('prependExtensionConfig')
            ->with('knp_gaufrette', [
                "adapters"    => [
                    "local_public"  => [
                        "local" => [
                            "directory" => "/tmp/public",
                            "create"    => true,
                        ],
                    ],
                    "local_private" => [
                        "local" => [
                            "directory" => "/tmp/public",
                            "create"    => true,
                        ],
                    ],
                ],
                "filesystems" => [
                    "local_public"  => [
                        "alias"   => "iad_filer.adapter.local.public",
                        "adapter" => "local_public",
                    ],
                    "local_private" => [
                        "alias"   => "iad_filer.adapter.local.private",
                        "adapter" => "local_private",
                    ],
                ],
            ]);

        $iadFilerTechExtension->prepend($containerBuilder);
    }

    /**
     * testErrorVisibilityConfig
     */
    public function testErrorVisibilityConfig()
    {
        $iadFilerTechExtension = new IadFilerTechExtension();

        $containerBuilder = $this->getContainerBuilderMock([
            'channels' => [
                'local' => [
                    'adapter'        => 'local',
                    'enable_public'  => false,
                    'enable_private' => false,
                    'public_path'    => '/tmp/public',
                    'private_path'   => '/tmp/public',
                ],
            ],
        ]);

        $this->setExpectedException(InvalidConfigurationException::class);

        $iadFilerTechExtension->prepend($containerBuilder);
    }

    /**
     * testErrorMissingPathConfig
     */
    public function testErrorMissingPathConfig()
    {
        $iadFilerTechExtension = new IadFilerTechExtension();

        $containerBuilder = $this->getContainerBuilderMock([
            'channels' => [
                'local' => [
                    'adapter'        => 'local',
                    'enable_public'  => true,
                    'enable_private' => false,
                    'private_path'   => '/tmp/public',
                ],
            ],
        ]);

        $this->setExpectedException(InvalidConfigurationException::class);

        $iadFilerTechExtension->prepend($containerBuilder);
    }

    /**
     * @param array $config
     *
     * @return \PHPUnit_Framework_MockObject_MockObject
     */
    private function getContainerBuilderMock($config = [])
    {
        $containerBuilder = $this->getMockBuilder(ContainerBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();


        $containerBuilder
            ->expects($this->at(0))
            ->method('getExtensionConfig')
            ->with('iad_filer_tech')
            ->willReturn([$config])
        ;

        $containerBuilder
            ->expects($this->at(1))
            ->method('getExtensionConfig')
            ->with('knp_gaufrette')
            ->willReturn([])
        ;

        return $containerBuilder;
    }
}
