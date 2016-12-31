<?php
namespace Bricks\Validation\Contextual\UnitTest;

use PHPUnit_Framework_TestCase;
use Bricks\Validation\Contextual\Specification;
use InvalidArgumentException;
use Bricks\Validation\Contextual\Message\Message;

/**
 * @author Artur Sh. Mamedbekov
 */
class SpecificationTest extends PHPUnit_Framework_TestCase{
  public function testConstruct(){
    $invalidMessage = new Message('test');
    $validSpec = new Specification(true, $invalidMessage);
    $invalidSpec = new Specification(false, $invalidMessage);

    $this->assertTrue($validSpec->isValid());
    $this->assertEquals([], $validSpec->getMessages());
    $this->assertFalse($invalidSpec->isValid());
    $this->assertEquals([$invalidMessage], $invalidSpec->getMessages());
  }

  public function testConstruct_shouldThrowExceptionIfGetInvalidArgs(){
    $this->setExpectedException(InvalidArgumentException::class);

    new Specification(1, new Message('test'));
  }
}
