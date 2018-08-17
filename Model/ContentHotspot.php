<?php

namespace ContentHotspotBundle\Model;

use Doctrine\ORM\Mapping as ORM;

/**
 * Class ContentHotspot
 * @ORM\MappedSuperclass()
 * @ORM\HasLifecycleCallbacks()
 */
class ContentHotspot implements ContentHotspotInterface
{
  /**
   * @var string
   *
   * @ORM\Id()
   * @ORM\Column(type="string", length=128, unique=true)
   */
  protected $alias;
  
  /**
   * @var string
   * @ORM\Column(type="string", length=256, nullable=true)
   */
  protected $title;
  
  /**
   * @var string
   * @ORM\Column(type="text")
   */
  protected $text;
  
  /**
   * @return string
   */
  public function getTitle()
  {
    return $this->title;
  }
  
  /**
   * @param string $title
   */
  public function setTitle($title)
  {
    $this->title = $title;
  }
  
  /**
   * @return string
   */
  public function getAlias()
  {
    return $this->alias;
  }
  
  /**
   * @param string $alias
   */
  public function setAlias($alias)
  {
    $this->alias = $alias;
  }
  
  /**
   * @return string
   */
  public function getText()
  {
    return $this->text;
  }
  
  /**
   * @param string $text
   */
  public function setText($text)
  {
    $this->text = $text;
  }
  
  public function __toString()
  {
    return (string)$this->getAlias() == null ? ' ' : ($this->getTitle() ? $this->getTitle() : $this->getAlias());
  }
}