<?php
/**
 * Created by PhpStorm.
 * User: agourram
 * Date: 03/10/18
 * Time: 09:46
 */

namespace Iad\Bundle\FilerTechBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Iad\Bundle\FilerTechBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Processor;

class FilerFormCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $config = $this->getConfiguration($container);
        $taggedServices = $container->findTaggedServiceIds('form.type');

        foreach ($taggedServices as $id => $tag) {
            $businessFilerName = str_replace('iad_filer.form.', '', $id);


            if (isset($config[$businessFilerName]['class'])) {
                $container->getDefinition($id)->addMethodCall('setClass', [$config[$businessFilerName]['class']]);
            }
        }
    }


    /**
     * @param ContainerBuilder $container
     *
     * @return array
     */
    private function getConfiguration(ContainerBuilder $container)
    {
        $configs       = $container->getExtensionConfig('iad_filer_tech');

        $configuration = new Configuration();
        $processor     = new Processor();
        $config        = $processor->processConfiguration($configuration, $configs);

        return $config;
    }
}
