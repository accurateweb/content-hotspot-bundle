<?php

namespace Accurateweb\ContentHotspotBundle\Service;

use Accurateweb\ContentHotspotBundle\Model\ContentHotspotInterface;
use Doctrine\ORM\EntityManagerInterface;

class ContentHotspotLoader
{
  private $entityManager;
  private $class;

  public function __construct (EntityManagerInterface $entityManager, $class)
  {
    $this->entityManager = $entityManager;
    $this->class = $class;
  }

  /**
   * @param ContentHotspotInterface $contentHotspot
   * @return ContentHotspotInterface
   */
  public function load (ContentHotspotInterface $contentHotspot)
  {
    $hotspot = $this->entityManager->getRepository($this->class)->findOneBy(['alias' => $contentHotspot->getAlias()]);

    if ($hotspot !== null)
    {
      return $hotspot;
    }

    return $contentHotspot;
  }
}