<?php

namespace VentureLeapUtilBundle;

use VentureLeapUtilBundle\DependencyInjection\CompilerPasses\DepersonalizePass;
use VentureLeapUtilBundle\DependencyInjection\CompilerPasses\AssetHandlerCompilerPass;
use VentureLeapUtilBundle\DependencyInjection\CompilerPasses\AssetProviderCompilerPass;
use VentureLeapUtilBundle\DependencyInjection\CompilerPasses\HealthCheckCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class VentureLeapUtilBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
    }
}
