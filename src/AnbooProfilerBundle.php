<?php

namespace Anboo\Profiler\Bundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Anboo\Profiler\Bundle\DependencyInjection\CompilerPass\CombineAuthenticatorResolverPass;
use Anboo\Profiler\Bundle\DependencyInjection\CompilerPass\TwigExtensionCompilerPass;
use Anboo\Profiler\Bundle\DependencyInjection\AnbooProfilerExtension;

class AnbooProfilerBundle extends Bundle
{
    /**
     * @return AnbooProfilerExtension
     */
    public function getContainerExtension()
    {
        return new AnbooProfilerExtension();
    }
}
