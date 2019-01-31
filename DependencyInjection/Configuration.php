<?php declare(strict_types = 1);

namespace Bukashk0zzz\FilterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the configuration class
 */
class Configuration implements ConfigurationInterface
{
    /**
     * Generates the configuration tree.
     *
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('bukashk0zzz_filter');

        $rootNode = \method_exists($treeBuilder, 'getRootNode')
            ? $treeBuilder->getRootNode()
            : $treeBuilder->root('bukashk0zzz_filter');

        $rootNode
            ->children()
            ->scalarNode('auto_filter_forms')->defaultValue(true)->end();

        return $treeBuilder;
    }
}
