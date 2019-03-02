<?php
/**
 * Created by PhpStorm.
 * User: anboo
 * Date: 02.03.19
 * Time: 10:14
 */

namespace Anboo\Profiler\Bundle\DependencyInjection;


use Anboo\Profiler\Transport\AsyncCurlBatchTransport;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('anboo_profiler');

        $rootNode
            ->children()
                ->scalarNode('host')->defaultValue('127.0.0.1')->end()
                ->integerNode('port')->defaultValue(25613)->end()
                ->scalarNode('transport_handler')->defaultValue(AsyncCurlBatchTransport::class)->end()
                ->booleanNode('profile_command')->defaultValue(true)->end()
                ->booleanNode('profile_controller')->defaultValue(true)->end()
                ->arrayNode('ignore_commands')
                    ->scalarPrototype()->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}