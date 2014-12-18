<?php
namespace Trt\Doctrine\Cache\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{

    /**
     * Generates the configuration tree builder.
     *
     * @return \Symfony\Component\Config\Definition\Builder\TreeBuilder The tree builder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('doctrine_encoded_cache');

        $rootNode
            ->children()
            ->scalarNode('key_provider')->cannotBeEmpty()->end()
            ->scalarNode('cache')->cannotBeEmpty()->end()
            ->end();

        return $treeBuilder;
    }
}