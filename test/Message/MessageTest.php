<?php
namespace Bricks\Validation\Contextual\UnitTest\Message;

use PHPUnit_Framework_TestCase;
use Bricks\Validation\Contextual\Message\Message;
use InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class MessageTest extends PHPUnit_Framework_TestCase{
  public function testConstruct(){
    $message = new Message('test');

    $this->assertEquals('test', $message->getMessage());
    $this->assertEquals('test', (string) $message);
  }

  public function testConstruct_shouldThrowExceptionIfGetInvalidArgs(){
    $this->setExpectedException(InvalidArgumentException::class);

    new Message(1);
  }
}
