<?php

namespace Accurateweb\ContentHotspotBundle\DependencyInjection\Compiler;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class HotspotLoaderCompilerPass implements CompilerPassInterface
{
  public function process (ContainerBuilder $container)
  {
    $config = $container->getExtensionConfig('content_hotspot');

    if ($config)
    {
      $_config = $config[0];

      $definition = $container->getDefinition('aw_clickzone.service.content_hotspot_pool');

      foreach ($_config['hotspots'] as $name => $configuration)
      {
        $definition->addMethodCall('addHotspot', array($name, $configuration));
      }
    }
  }

}