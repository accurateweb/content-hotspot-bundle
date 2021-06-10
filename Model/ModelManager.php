<?php
/**
 * Copyright (c) 2017. Denis N. Ragozin <dragozin@accurateweb.ru>
 *
 * For the full copyright and license information, please view the LICENSE file that was distributed with this source code.
 */

/**
 * @author Denis N. Ragozin <dragozin@accurateweb.ru>
 */

namespace Accurateweb\ContentHotspotBundle\Model;

use Accurateweb\ContentHotspotBundle\Exception\HotspotNotFoundException;
use Accurateweb\ContentHotspotBundle\Service\ContentHotspotPool;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager as BaseModelManager;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class ModelManager extends BaseModelManager
{
  private $contentHotspotPool;

  function __construct (RegistryInterface $registry, ContentHotspotPool $contentHotspotPool)
  {
    $this->contentHotspotPool = $contentHotspotPool;

    parent::__construct($registry);
  }

  public function createQuery ($class, $alias = 'o')
  {
    $repository = $this->getEntityManager($class)->getRepository($class);

    return new ProxyQuery($repository->createQueryBuilder($alias), $class, $this->contentHotspotPool,
      $this->registry->getManager());
  }

  public function find ($class, $id)
  {
    /** @var ContentHotspotInterface $obj */
    $obj = $this->createQuery($class)
      ->getQueryBuilder()
      ->where('o.alias = :alias')
      ->setParameter('alias', $id)
      ->getQuery()
      ->getOneOrNullResult();

    try
    {
      $template = $this->contentHotspotPool->getHotspot($id);

      if (!$obj)
      {
        /** @var ContentHotspotInterface $obj */
        $obj = new $class();
        $obj->setAlias($id);
        $obj->setText($template->getText());
        $obj->setTitle($template->getTitle());

        $this->registry->getManager()->persist($obj);
      }
      else
      {
//        $obj->setTitle($template->getTitle());
//        $obj->setText($template->getText());
      }
    }
    catch (HotspotNotFoundException $e)
    {
      if ($obj)
      {
        $obj = null;
      }
    }

    return $obj;
  }
}