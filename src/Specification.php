<?php
namespace Bricks\Validation\Contextual;

use Bricks\Validation\Contextual\Message\MessageInterface;
use InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class Specification extends AbstractSpecification{
  /**
   * @var bool
   */
  private $isValid;

  /**
   * @param bool $isValid true - если спецификация считается выполненной.
   * @param MessageInterface $invalidMessage Сообщение о причинах нарушения 
   * спецификации.
   *
   * @throws InvalidArgumentException
   */
  public function __construct($isValid, MessageInterface $invalidMessage){
    if(!is_bool($isValid)){
      throw new InvalidArgumentException(sprintf(
        'Argument 1 passed to %s::%s must be bool, %s given.',
        __CLASS__,
        __METHOD__,
        is_object($isValid)? get_class($isValid) : gettype($isValid)
      ));
    }

    $this->isValid = $isValid;
    if(!$this->isValid()){
      $this->messages[] = $invalidMessage;
    }
  }

  /**
   * {@inheritdoc}
   */
  public function isValid(){
    return $this->isValid;
  }
}
