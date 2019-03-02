<?php

namespace Anboo\Profiler\Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Anboo\Profiler\Bundle\Debug\DebugAwareTrait;

/**
 * AnbooProfilerExtension.
 */
class AnbooProfilerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('anboo_profiler.profile_command', $config['profile_command']);
        $container->setParameter('anboo_profiler.profile_controller', $config['profile_controller']);
        $container->setParameter('anboo_profiler.host', $config['host']);
        $container->setParameter('anboo_profiler.port', $config['port']);
        $container->setParameter('anboo_profiler.transport_handler', $config['transport_handler']);
        $container->setParameter('anboo_profiler.ignore_commands', $config['ignore_commands']);
        $container->setParameter('anboo_profiler.ignore_routes', $config['ignore_routes']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
