<?php
namespace Iad\Bundle\FilerTechBundle\DependencyInjection\Compiler;

use Iad\Bundle\FilerTechBundle\DependencyInjection\Configuration;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Config\Definition\Exception\InvalidDefinitionException;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class FilerAdaptersCompilerPass
 *
 * @package Iad\Bundle\FilerTechBundle\DependencyInjection
 */
class FilerAdaptersCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $taggedServices = $container->findTaggedServiceIds('iad_filer.business.service');

        $config = $this->getConfiguration($container);
        foreach ($taggedServices as $id => $tags) {
            $businessFilerName = str_replace('iad_filer.', '', $id);

            if (!isset($config[$businessFilerName]) || !isset($config['channels'][$config[$businessFilerName]['channel']])) {
                throw new InvalidConfigurationException(
                    sprintf("missing channel configuration for business filer service <%s>", $businessFilerName)
                );
            }

            $businessChannel   = $config[$businessFilerName]['channel'];

            if ($config['channels'][$businessChannel]['enable_public']) {
                $this->injectPublicFileSystem($container, $businessChannel, $id);
            }

            if ($config['channels'][$businessChannel]['enable_private']) {
                $this->injectPrivateFileSystem($container, $businessChannel, $id);
            }

            if (isset($config[$businessFilerName]['resizing_filters'])) {
                $container->getDefinition($id)->addMethodCall('setResizingFilters', [$config[$businessFilerName]['resizing_filters']]);
            }

            if (isset($config[$businessFilerName]['watermark_filter'])) {
                $container->getDefinition($id)->addMethodCall('setWaterMarkFilter', [$config[$businessFilerName]['watermark_filter']]);
            }

            if (isset($config[$businessFilerName]['public_base_url'])) {
                $container->getDefinition($id)->addMethodCall('setPublicBaseUrl', [$config[$businessFilerName]['public_base_url']]);
            }

            if (isset($config[$businessFilerName]['class_file'])) {
                $container->getDefinition($id)->addMethodCall('setClass', [$config[$businessFilerName]['class_file']]);
            }

            if (isset($config[$businessFilerName]['document_type'])) {
                $container->getDefinition($id)->addMethodCall('setDocumentType', [$config[$businessFilerName]['document_type']]);
            }

            if (isset($config[$businessFilerName]['directory_prefix'])) {
                $container->getDefinition($id)->addMethodCall('setDirectoryPrefix', [$config[$businessFilerName]['directory_prefix']]);
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

    /**
     * @param ContainerBuilder $container
     * @param                  $businessChannel
     * @param                  $serviceId
     */
    private function injectPublicFileSystem(ContainerBuilder $container, $businessChannel, $serviceId)
    {
        $this->injectFileSystem($container, 'public', $businessChannel, $serviceId);
    }

    /**
     * @param ContainerBuilder $container
     * @param                  $businessChannel
     * @param                  $serviceId
     */
    private function injectPrivateFileSystem(ContainerBuilder $container, $businessChannel, $serviceId)
    {
        $this->injectFileSystem($container, 'private', $businessChannel, $serviceId);
    }

    /**
     * @param ContainerBuilder $container
     * @param string           $access
     * @param string           $businessChannel
     * @param string           $serviceId
     */
    private function injectFileSystem(ContainerBuilder $container, $access, $businessChannel, $serviceId)
    {
        if (in_array($access, ['public', 'private']) === false) {
            throw new \InvalidArgumentException(
                sprintf(
                    "invalid visibility parameter, must be public or private, %s given",
                    $access
                )
            );
        }

        if ($container->has('iad_filer.adapter.'.$businessChannel.'.'.$access) === false) {
            throw new InvalidDefinitionException(
                sprintf(
                    "missing %s channel service definition <%s> for service <%s>",
                    $access,
                    'iad_filer.adapter.'.$businessChannel.'.'.$access,
                    $serviceId
                )
            );
        }
        $method = 'set'.ucfirst($access).'Filesystem';
        $definition = $container->getDefinition($serviceId);
        $definition->addMethodCall($method, [new Reference('iad_filer.adapter.'.$businessChannel.'.'.$access)]);
    }
}
