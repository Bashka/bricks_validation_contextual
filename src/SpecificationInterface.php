<?php
namespace Bricks\Validation\Contextual;

use Bricks\Validation\Contextual\Message\MessageInterface;

/**
 * @author Artur Sh. Mamedbekov
 */
interface SpecificationInterface{
  /**
   * @return bool true - если спецификация выполняется.
   */
  public function isValid();

  /**
   * @return MessageInterface Информация о причинах нарушения спецификации.
   */
  public function getMessages();
}
