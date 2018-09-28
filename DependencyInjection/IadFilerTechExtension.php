<?php

namespace Iad\Bundle\FilerTechBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class IadFilerTechExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $config = $this->processConfiguration(new Configuration(), $configs);


        foreach ($config['channels'] as $channelName => $channel) {
//            $container->getDefinition('gaufrette.adapter')
//                ->addArgument()
        }

//        $gaufretteAdapter = $container->getDefinition('gaufrette.adapter');
//        $gaufretteAdapter->getArguments()
//        $gaufretteAdapter->addArgument($config['root_path']);
    }

}