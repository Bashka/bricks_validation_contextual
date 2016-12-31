<?php
namespace Bricks\Validation\Contextual\Message;

/**
 * @author Artur Sh. Mamedbekov
 */
interface MessageInterface{
  /**
   * @return string Строка, содержащая причину нарушения верификации.
   */
  public function getMessage();
}
