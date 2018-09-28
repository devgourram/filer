<?php

namespace Iad\Bundle\FilerTechBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class IadFilerTechExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
    }

    /**
     * create gaufrettte filesystem services from iad_filer config
     * @param ContainerBuilder $container
     */
    public function prepend(ContainerBuilder $container)
    {
        $configFiler = $this->processConfiguration(new Configuration(), $container->getExtensionConfig($this->getAlias()));
        $configGaufrette = $this->processConfiguration(new Configuration(), $container->getExtensionConfig('knp_gaufrette'));

        foreach ($configFiler['channels'] as $channelName => $channel) {
            if (!$channel['enable_public'] && !$channel['enable_private']) {
                throw new InvalidConfigurationException(
                    sprintf("iad_tech_filer - channel %s must have a public or private path activated", $channelName)
                );
            }

            $adapter = $channel['adapter'];
            if ($channel['enable_public']) {
                if (!isset($channel['public_path']) || empty($channel['public_path'])) {
                    throw new InvalidConfigurationException(
                        sprintf("iad_tech_filer - invalid public_path for channel %s", $channelName)
                    );
                }
                $configGaufrette['adapters'][$channelName.'_public'][$adapter] = [
                    'directory' => $channel['public_path'],
                    'create'    => true,
                ];
                $configGaufrette['filesystems'][$channelName.'_public']['alias'] = "iad_filer.adapter.$channelName.public";
                $configGaufrette['filesystems'][$channelName.'_public']['adapter'] = $channelName.'_public';
            }

            if ($channel['enable_private']) {
                if (!isset($channel['private_path']) || empty($channel['private_path'])) {
                    throw new InvalidConfigurationException(
                        sprintf("iad_tech_filer - invalid private_path for channel %s", $channelName)
                    );
                }
                $configGaufrette['adapters'][$channelName.'_private'][$adapter] = [
                    'directory' => $channel['private_path'],
                    'create'    => true,
                ];
                $configGaufrette['filesystems'][$channelName.'_private']['alias'] = "iad_filer.adapter.$channelName.private";
                $configGaufrette['filesystems'][$channelName.'_private']['adapter'] = $channelName.'_private';
            }
        }

        $container->prependExtensionConfig('knp_gaufrette', $configGaufrette);
    }
}
