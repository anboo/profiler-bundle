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
                ->scalarNode('host')->isRequired()->defaultValue('127.0.0.1')->end()
                ->integerNode('port')->isRequired()->defaultValue(25613)->end()
                ->scalarNode('transport_handler')->isRequired()->defaultValue(AsyncCurlBatchTransport::class)->end()
                ->booleanNode('profile_command')->isRequired()->defaultValue(true)->end()
                ->booleanNode('profile_controller')->isRequired()->defaultValue(true)->end()
            ->end()
        ;

        return $treeBuilder;
    }
}