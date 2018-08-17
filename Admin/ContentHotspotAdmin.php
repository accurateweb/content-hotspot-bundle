<?php
/**
 * Created by PhpStorm.
 * User: eobuh
 * Date: 27.07.2018
 * Time: 15:35
 */

namespace ContentHotspotBundle\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

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
    $form
      ->add('title')
      ->add('alias');
    
    if (!class_exists('tinymce'))
    {
      $form->add('text', 'textarea', [
        'required' => true,
        'help' => 'Install TinyMce or another WISYWIG or override field.'
      ]);
    } else
    {
      $form
        ->add('text', 'tinymce', [
          'attr' => [
            'class' => 'tinymce',
            'tinymce' => '{"theme":"simple"}',
            'data-theme' => 'bbcode',
          ],
          'required' => true
        ]);
    }
    
  }
  
}