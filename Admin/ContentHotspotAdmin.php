<?php

namespace Accurateweb\ContentHotspotBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Route\RouteCollection;

class ContentHotspotAdmin extends AbstractAdmin
{
  public function configureListFields(ListMapper $list)
  {
    $list
      ->add('title')
      ->add('alias')
      ->add('text')
      ->add('_action', null, [
        'actions' => [
          'edit' => [],
          'delete' => []
        ]]);
  }
  
  public function configureFormFields(FormMapper $form)
  {
    $form->add('text', 'textarea', [
      'required' => true,
      'help' => 'Install TinyMce or another WISYWIG or override field.',
    ]);
  }

  protected function configureRoutes (RouteCollection $collection)
  {
    $collection->remove('create');
    $collection->remove('export');
    $collection->remove('delete');
  }

}