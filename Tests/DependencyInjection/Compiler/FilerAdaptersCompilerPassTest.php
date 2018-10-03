<?php
namespace Iad\Bundle\FilerTechBundle\Tests\DependencyInjection\Compiler;

use AppBundle\Entity\Picture;
use Iad\Bundle\FilerTechBundle\DependencyInjection\Compiler\FilerAdaptersCompilerPass;
use Iad\Bundle\FilerTechBundle\Model\PictureFile;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * Class FilerAdaptersCompilerPassTest
 *
 * @package Iad\Bundle\FilerTechBundle\Tests\DependencyInjection
 */
class FilerAdaptersCompilerPassTest extends \PHPUnit_Framework_TestCase
{
    /**
     * successConfigTest
     */
    public function testSuccess()
    {
        $iadFilerTechExtension = new FilerAdaptersCompilerPass();

        $containerBuilder = $this->getContainerBuilderMock();
        $containerBuilder
            ->method('findTaggedServiceIds')
            ->willReturn(['iad_filer.picture_filer' => []]);

        $containerBuilder
            ->method('getExtensionConfig')
            ->willReturn([
                [
                    'channels' => [
                        'local' => [
                            'adapter'        => 'local',
                            'enable_public'  => true,
                            'enable_private' => true,
                            'public_path'    => '/tmp/public',
                            'private_path'   => '/tmp/public',
                        ],
                    ],
                    'picture_filer' => [
                        'channel' => 'local',
                        'class' => 'anything',
                        'class_file' => 'anything'
                    ],
                ],
            ]);

        $containerBuilder
            ->expects($this->exactly(2))
            ->method('has')
            ->willReturn(true);

        $definition = $this->getMockBuilder(Definition::class)
            ->disableOriginalConstructor()
            ->getMock();

        $definition
            ->expects($this->at(0))
            ->method('addMethodCall')
            ->with('setPublicFilesystem', $this->anything())
            ;

        $definition
            ->expects($this->at(1))
            ->method('addMethodCall')
            ->with('setPrivateFilesystem', $this->anything())
        ;

        $definition
            ->expects($this->at(2))
            ->method('addMethodCall')
            ->with('setResizingFilters', $this->anything())
        ;

        $definition
            ->expects($this->at(3))
            ->method('addMethodCall')
            ->with('setClass', $this->anything())
        ;

        $definition
            ->expects($this->at(4))
            ->method('addMethodCall')
            ->with('setDocumentType', $this->anything())
        ;

        $definition
            ->expects($this->at(5))
            ->method('addMethodCall')
            ->with('setDirectoryPrefix', $this->anything())
        ;


        $containerBuilder
            ->expects($this->exactly(3))
            ->method('getDefinition')
            ->with('iad_filer.picture_filer')
            ->willReturn($definition);

        $iadFilerTechExtension->process($containerBuilder);
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

        return $containerBuilder;
    }
}
