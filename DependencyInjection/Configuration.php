<?php

namespace Iad\Bundle\FilerTechBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $root = $treeBuilder->root('iad_filer_tech');

        $root
            ->children()
                ->arrayNode('channels')
                ->info('List all channels available')
                    ->children()
                        ->arrayNode('local')
                        ->info('Local channel configuration')
                        ->children()
                            ->scalarNode('adapter')
                                ->info('gaufrette adapter used')
                            ->end()
                            ->scalarNode('public_path')
                                ->info('path used for public storage configuration')
                            ->end()
                            ->scalarNode('private_path')
                                ->info('path used for private storage configuration')
                            ->end()
                            ->booleanNode('enable_public')
                                ->isRequired()
                                ->info('enable public storage configuration')
                            ->end()
                            ->booleanNode('enable_private')
                                ->isRequired()
                                ->info('enable private storage configuration')
                            ->end()
                        ->end()
                    ->end()
            ->end();

        return $treeBuilder;
    }
}