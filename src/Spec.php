<?php
namespace Bricks\Validation\Contextual;

use Bricks\Validation\Contextual\Message\MessageInterface;
use Bricks\Validation\Contextual\Message\Message;

/**
 * @author Artur Sh. Mamedbekov
 */
class Spec{
  public static function compos(){
    return new CompositeSpecification(func_get_args());
  }

  public static function is($isValid, $invalidMessage){
    if(!$invalidMessage instanceof MessageInterface){
      $invalidMessage = new Message($invalidMessage);
    }

    return new Specification($isValid, $invalidMessage);
  }
}
