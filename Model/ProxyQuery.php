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

use Accurateweb\ContentHotspotBundle\Service\ContentHotspotPool;
use Sonata\DoctrineORMAdminBundle\Datagrid\ProxyQuery as BaseProxyQuery;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;

class ProxyQuery extends BaseProxyQuery
{
  private $contentHotspotPool;
  private $class;
  private $entityManager;

  public function __construct (
    QueryBuilder $queryBuilder,
    $class,
    ContentHotspotPool $contentHotspotPool,
    EntityManager $entityManager)
  {
    $this->contentHotspotPool = $contentHotspotPool;
    $this->class = $class;
    $this->entityManager = $entityManager;

    parent::__construct($queryBuilder);
  }

  public function execute (array $params = array(), $hydrationMode = null)
  {
    $result = parent::execute($params, $hydrationMode);
    $templateList = $this->contentHotspotPool->getHotspots();
    $newResult = new ArrayCollection();

    foreach ($templateList as $alias => $template)
    {
      $found = false;
      /* @var $existingTemplateObject ContentHotspotInterface */
      foreach ($result as $existingTemplateObject)
      {
        if ($existingTemplateObject->getAlias() == $alias)
        {
          $found = true;
          $newResult->add($existingTemplateObject);

          $existingTemplateObject->setTitle($template->getTitle());
          $existingTemplateObject->setText($template->getText());

          break;
        }
      }

      if (!$found)
      {
        $class = $this->class;
        /** @var ContentHotspotInterface $newTemplate */
        $newTemplate = new $class;
        $newTemplate->setText($template->getText());
        $newTemplate->setTitle($template->getTitle());
        $newTemplate->setAlias($alias);
        $this->entityManager->persist($newTemplate);
        $newResult->add($newTemplate);
      }
    }

    $this->result = $newResult;

    return $newResult;
  }
}