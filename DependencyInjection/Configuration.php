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
                // NEW CODE ADDED BY TEAM WEB
                ->arrayNode('picture_filer')
                    ->info('Picture filer configuration')
                    ->children()
                        ->scalarNode('channel')->end()
                        ->arrayNode('resizing_filters')
                            ->prototype('scalar')->end()
                        ->end()
                        ->scalarNode('watermark_filter')->end()
                        ->scalarNode('public_base_url')->end()
                        ->scalarNode('class_file')
                            ->isRequired()
                        ->end()
                        ->scalarNode('class')
                            ->isRequired()
                        ->end()
                        ->scalarNode('document_type')
                            ->defaultValue('picture')
                            ->isRequired()
                        ->end()
                        ->scalarNode('directory_prefix')
                            ->defaultValue('picture/')
                            ->isRequired()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('document_filer')
                ->info('Document filer configuration')
                ->children()
                    ->scalarNode('channel')->end()
                    ->scalarNode('document_type')
                        ->defaultValue('document')
                        ->isRequired()
                    ->end()
                    ->scalarNode('directory_prefix')
                        ->defaultValue('document/')
                        ->isRequired()
                    ->end()
                    ->scalarNode('class')
                        ->isRequired()
                    ->end()
                ->end()
                ->end()
                // NEW CODE ADDED BY TEAM WEB
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
                ->end()
            ->end();

        return $treeBuilder;
    }
}
