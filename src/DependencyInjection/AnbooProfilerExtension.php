<?php

namespace Anboo\Profiler\Bundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Anboo\Profiler\Bundle\Debug\DebugAwareTrait;

/**
 * WebslonSettingsExtension.
 */
class AnbooProfilerExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $container->setParameter('anboo_profiler.profile_command', $configs['profile_command']);
        $container->setParameter('anboo_profiler.profile_controller', $configs['profile_controller']);
        $container->setParameter('anboo_profiler.host', $configs['host']);
        $container->setParameter('anboo_profiler.port', $configs['port']);
        $container->setParameter('anboo_profiler.transport_handler', $configs['transport_handler']);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }
}
