<?php

namespace Iad\Bundle\FilerTechBundle\DependencyInjection;

use Iad\Bundle\FilerTechBundle\Entity\Document;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
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
                ->end()
            ->end();

        $this->addPictureFiler($root);
        $this->addDocumentFiler($root);

        return $treeBuilder;
    }


    private function addPictureFiler(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('picture_filer')->canBeUnset()
                 ->info('Picture filer configuration')
            ->children()
                ->scalarNode('channel')->end()
                ->scalarNode('public_base_url')->end()
                    ->arrayNode('entries')
                        ->useAttributeAsKey('name')
                        ->prototype('array')
                        ->children()
                            ->arrayNode('resizing_filters')
                                ->prototype('scalar')
                            ->end()
							->end()
                            ->scalarNode('watermark_filter')->end()
                            ->scalarNode('class')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('document_type')
                                ->defaultValue('picture')
                            ->end()
                            ->scalarNode('directory_prefix')
                                ->defaultValue('picture/')
                                ->end()
                            ->end()
                        ->end()
                ->end()
        ->end();

    }

    private function addDocumentFiler(ArrayNodeDefinition $rootNode)
    {
        $rootNode
            ->children()
                ->arrayNode('document_filer')->canBeUnset()
                ->info('Document filer configuration')
                    ->children()
                        ->scalarNode('channel')
                    ->end()
                    ->arrayNode('entries')
                        ->useAttributeAsKey('name')
                        ->prototype('array')
                        ->children()
                            ->scalarNode('class')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('document_type')
                                ->defaultValue('picture')
                            ->end()
                            ->scalarNode('directory_prefix')
                                ->defaultValue('document/')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }
}
