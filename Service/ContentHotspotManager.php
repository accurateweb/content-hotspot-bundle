<?php

namespace Accurateweb\ContentHotspotBundle\Service;

class ContentHotspotManager
{
  private $contentHotspotPool;
  private $contentHotspotLoader;

  public function __construct (ContentHotspotPool $contentHotspotPool, ContentHotspotLoader $contentHotspotLoader)
  {
    $this->contentHotspotPool = $contentHotspotPool;
    $this->contentHotspotLoader = $contentHotspotLoader;
  }

  /**
   * @param $alias
   * @return \Accurateweb\ContentHotspotBundle\Model\ContentHotspotInterface
   * @throws \Accurateweb\ContentHotspotBundle\Exception\HotspotNotFoundException
   */
  public function getHotspot ($alias)
  {
    $hotspot = $this->contentHotspotPool->getHotspot($alias);

    return $this->contentHotspotLoader->load($hotspot);
  }
}