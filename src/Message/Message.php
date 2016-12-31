<?php
namespace Bricks\Validation\Contextual\Message;

use InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class Message implements MessageInterface{
  /**
   * @var string
   */
  private $message;

  /**
   * @param string $message Причина нарушения верификации.
   *
   * @throws InvalidArgumentException Выбрасывается при получение сообщения 
   * недопустимого типа.
   */
  public function __construct($message){
    if(is_object($message) && method_exists($message, '__toString')){
      $message = (string) $message;
    }
    if(!is_string($message)){
      throw new InvalidArgumentException(sprintf(
        'Message should be a string or convertible to a string object, %s given',
        gettype($message)
      ));
    }

    $this->message = $message;
  }

  /**
   * {@inheritdoc}
   */
  public function getMessage(){
    return $this->message;
  }

  /**
   * @see self::getMessage
   *
   * @return string
   */
  public function __toString(){
    return $this->getMessage();
  }
}
