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
                ->arrayNode('avatar_filer')
                    ->info('avatar filer configuration')
                    ->children()
                        ->scalarNode('channel')->end()
                        ->arrayNode('resizing_filters')
                            ->prototype('scalar')->end()
                        ->end()
                        ->scalarNode('watermark_filter')->end()
                        ->scalarNode('public_base_url')->end()
                    ->end()
                ->end()
                ->arrayNode('realestate_picture_filer')
                    ->info('real estate pictures filer configuration')
                    ->children()
                        ->scalarNode('channel')->end()
                        ->arrayNode('resizing_filters')
                            ->prototype('scalar')->end()
                        ->end()
                        ->scalarNode('watermark_filter')->end()
                        ->scalarNode('public_base_url')->end()
                    ->end()
                ->end()
                ->arrayNode('event_picture_filer')
                    ->info('event pictures filer configuration')
                    ->children()
                        ->scalarNode('channel')->end()
                        ->arrayNode('resizing_filters')
                            ->prototype('scalar')->end()
                        ->end()
                        ->scalarNode('watermark_filter')->end()
                        ->scalarNode('public_base_url')->end()
                    ->end()
                ->end()

                ->arrayNode('training_pole_picture_filer')
                    ->info('training pole pictures filer configuration')
                    ->children()
                        ->scalarNode('channel')->end()
                        ->arrayNode('resizing_filters')
                            ->prototype('scalar')->end()
                        ->end()
                        ->scalarNode('watermark_filter')->end()
                        ->scalarNode('public_base_url')->end()
                    ->end()
                ->end()

                ->arrayNode('administrative_document_filer')
                    ->info('administrative document filer configuration')
                    ->children()
                        ->scalarNode('channel')->end()
                    ->end()
                ->end()
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
