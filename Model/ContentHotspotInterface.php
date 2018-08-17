<?php

namespace ContentHotspotBundle\Model;


interface ContentHotspotInterface
{
  /** @return string */
  public function getAlias();
  /** @return string */
  public function getTitle();
  /** @return string */
  public function getText();
  
  /**
   * @param string
   * @return void
   */
  public function setAlias($alias);
  
  /**
   * @param string
   * @return void
   */
  public function setTitle($title);
  
  /**
   * @param string
   * @return void
   */
  public function setText($text);
  
}