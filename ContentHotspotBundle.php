<?php

namespace Accurateweb\ContentHotspotBundle;

use Accurateweb\ContentHotspotBundle\DependencyInjection\Compiler\HotspotLoaderCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class ContentHotspotBundle extends Bundle
{
  public function build (ContainerBuilder $container)
  {
    parent::build($container);
    $container->addCompilerPass(new HotspotLoaderCompilerPass());
  }
}