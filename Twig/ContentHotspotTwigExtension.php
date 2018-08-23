<?php

namespace Accurateweb\ContentHotspotBundle\Twig;

use Accurateweb\ContentHotspotBundle\Model\ContentHotspot;
use Accurateweb\ContentHotspotBundle\Model\ContentHotspotInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Doctrine\ORM\EntityManagerInterface;
use Sonata\AdminBundle\Admin\AdminInterface;

class ContentHotspotTwigExtension extends \Twig_Extension
{
  private $em, $clickZoneAdmin, $clickZoneEntity, $session, $provider, $canEdit;
  
  public function __construct(EntityManagerInterface $manager, AdminInterface $admin, $entity, Session $session, $provider)
  {
    $this->em = $manager;
    $this->clickZoneAdmin = $admin;
    $this->clickZoneEntity = $entity;
    $this->provider = $provider;
    $this->session = $session;
    $this->setCanEdit();
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
    $canEdit = false;
    
    $provider = '_security_' . $this->provider;
    
    $usernamePasswordToken = $this->session->get($provider);
    $usernamePasswordToken = unserialize($usernamePasswordToken);
    
    if ($usernamePasswordToken !== false)
    {
      /** @var Symfony\Component\Security\Core\Role\Role $role */
      foreach ($usernamePasswordToken->getRoles() as $role)
      {
        if ($role->getRole() === "ROLE_ADMIN")
        {
          $canEdit = true;
          break;
        }
      }
    }
    
    $clickZone = $this->em->getRepository($this->clickZoneEntity)->findOneBy(['alias' => $alias]);
    
    if (!$clickZone)
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
      'canEdit' => $canEdit
    ));
  }
  
  public function getInlineHotspot(\Twig_Environment $environment, $alias, $defaultContent = '')
  {
    $clickZone = $this->em->getRepository($this->clickZoneEntity)->findOneBy(['alias' => $alias]);
    
    if (!$clickZone)
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
      'canEdit' => $this->canEdit
    ));
  }
  
  public function setCanEdit()
  {
    $this->canEdit = false;
    
    $provider = '_security_' . $this->provider;
    
    $usernamePasswordToken = $this->session->get($provider);
    $usernamePasswordToken = unserialize($usernamePasswordToken);
    
    if ($usernamePasswordToken !== false)
    {
      /** @var Symfony\Component\Security\Core\Role\Role $role */
      foreach ($usernamePasswordToken->getRoles() as $role)
      {
        if ($role->getRole() === "ROLE_ADMIN")
        {
          $this->canEdit = true;
          break;
        }
      }
    }
  }
}
