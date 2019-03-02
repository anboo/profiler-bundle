<?php
/**
 * Created by PhpStorm.
 * User: anboo
 * Date: 02.03.19
 * Time: 10:14
 */

namespace Anboo\Profiler\Bundle\DependencyInjection;


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
                ->booleanNode('profile_commands')->isRequired()->defaultValue(true)->end()
                ->booleanNode('profile_controllers')->isRequired()->defaultValue(true)->end()
            ->end()
        ;

        return $treeBuilder;
    }
}