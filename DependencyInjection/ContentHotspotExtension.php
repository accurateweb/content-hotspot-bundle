<?php

namespace Accurateweb\ContentHotspotBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ContentHotspotExtension extends Extension
{
  public function load(array $config, ContainerBuilder $container)
  {
    $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
    $loader->load('services.yml');
  }
}