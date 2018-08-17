<?php

namespace ContentHotspotBundle\Controller;

use ContentHotspotBundle\Model\ContentHotspot;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ContentHotspotController extends Controller
{
  public function editAction(Request $request)
  {
    $alias = $request->get('alias');
    $text = $request->get('text');
    
    $clickZone = $this->getDoctrine()
      ->getRepository($this->getParameter('hotspot_entity'))
      ->findOneBy(['alias' => $alias]);
    
    if (!$clickZone)
    {
      $clickZone = new ContentHotspot();
      $clickZone->setAlias($alias);
    }
    
    $clickZone->setText($text);
    
    $this->getDoctrine()->getManager()->persist($clickZone);
    try
    {
      $this->getDoctrine()->getManager()->flush();
    } catch (\Exception $exception)
    {
      return new JsonResponse(['error' => $exception->getMessage()], 400);
    }
    
    return new JsonResponse(['text' => $clickZone->getText()], 200);
    
  }
}