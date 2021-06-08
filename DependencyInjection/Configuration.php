<?php
/**
 * Copyright (c) 2017. Denis N. Ragozin <dragozin@accurateweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\ContentHotspotBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
  public function getConfigTreeBuilder()
  {
    $treeBuilder = new TreeBuilder();

    $rootNode = $treeBuilder->root('aw_content_hotspot');

    $rootNode
      ->children()
        ->arrayNode('hotspots')
          ->prototype('array')
            ->children()
              ->scalarNode('alias')->end()
              ->scalarNode('description')->end()
              ->arrayNode('defaults')
                ->children()
                  ->scalarNode('title')->end()
                  ->scalarNode('text')->end()
                ->end()
              ->end()
            ->end()
          ->end()
        ->end()
      ->end();

    return $treeBuilder;
  }

}