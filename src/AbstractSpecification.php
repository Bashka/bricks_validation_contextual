<?php
namespace Bricks\Validation\Contextual;

use Bricks\Validation\Contextual\Message\MessageInterface;

/**
 * @author Artur Sh. Mamedbekov
 */
abstract class AbstractSpecification implements SpecificationInterface{
  /**
   * @var MessageInterface[]
   */
  protected $messages = [];

  /**
   * {@inheritdoc}
   */
  public function getMessages(){
    return $this->messages;
  }
}
