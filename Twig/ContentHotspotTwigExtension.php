<?php

namespace Accurateweb\ContentHotspotBundle\Twig;

use Accurateweb\ContentHotspotBundle\Model\ContentHotspot;
use Accurateweb\ContentHotspotBundle\Model\ContentHotspotInterface;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

class ContentHotspotTwigExtension extends \Twig_Extension
{
  private $em, $clickZoneAdmin, $clickZoneEntity;
 
  public function __construct(EntityManagerInterface $manager, AdminInterface $admin, $entity)
  {
    $this->em = $manager;
    $this->clickZoneAdmin = $admin;
    $this->clickZoneEntity = $entity;
  }
  
  public function getFunctions()
  {
    return array(
      new \Twig_SimpleFunction('hotspot_inline', array($this, 'getInlineHotspot'), array('needs_environment' => TRUE, 'is_safe' => array('html'))),
      new \Twig_SimpleFunction('hotspot', array($this, 'getHotspot'), array('needs_environment' => TRUE, 'is_safe' => array('html')))
    );
  }
  
  public function getHotspot(\Twig_Environment $environment, $alias, $defaultContent = '')
  {
    $clickZone =  $this->em->getRepository($this->clickZoneEntity)->findOneBy(['alias' => $alias]);
    
    if(!$clickZone)
    {
      /** @var ContentHotspotInterface $clickZone */
      $clickZone = new $this->clickZoneEntity();
      
      $clickZone->setText($defaultContent);
      $clickZone->setTitle('');
      $clickZone->setAlias($alias);
      
      $this->em->persist($clickZone);
      $this->em->flush();
    }
    
    return $environment->render('@ContentHotspot/content_hotspot_default.html.twig', array(
      'adminPath' => $this->clickZoneAdmin->generateUrl('edit', ['id' => $alias]),
      'clickZone' => $clickZone,
    ));
  }
  
  public function getInlineHotspot(\Twig_Environment $environment, $alias, $defaultContent = '')
  {
    $clickZone =  $this->em->getRepository($this->clickZoneEntity)->findOneBy(['alias' => $alias]);
    
    if(!$clickZone)
    {
      /** @var ContentHotspotInterface $clickZone */
      $clickZone = new $this->clickZoneEntity();
      
      $clickZone->setText($defaultContent);
      $clickZone->setTitle('');
      $clickZone->setAlias($alias);
      
      $this->em->persist($clickZone);
      $this->em->flush();
    }
    
    return $environment->render('@ContentHotspot/content_hotspot_inline.html.twig', array(
      'adminPath' => $this->clickZoneAdmin->generateUrl('edit', ['id' => $alias]),
      'clickZone' => $clickZone,
    ));
  }
}
