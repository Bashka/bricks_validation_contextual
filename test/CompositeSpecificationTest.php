<?php
namespace Bricks\Validation\Contextual\UnitTest;

use PHPUnit_Framework_TestCase;
use Bricks\Validation\Contextual\CompositeSpecification;
use Bricks\Validation\Contextual\Specification;
use InvalidArgumentException;
use Bricks\Validation\Contextual\Message\Message;

/**
 * @author Artur Sh. Mamedbekov
 */
class CompositeSpecificationTest extends PHPUnit_Framework_TestCase{
  public function testConstruct(){
    new CompositeSpecification([
      new Specification(true, new Message('test')),
      new Specification(true, new Message('test')),
      new Specification(true, new Message('test')),
    ]);
  }

  public function testConstruct_shouldThrowExceptionIfGetInvalidArgs(){
    $this->setExpectedException(InvalidArgumentException::class);

    new CompositeSpecification([1]);
  }

  public function testIsValid_shouldAggregateInvalidMessages(){
    $compSpec = new CompositeSpecification([
      new Specification(true, new Message('a')),
      new Specification(false, new Message('b')),
      new CompositeSpecification([
        new Specification(true, new Message('c')),
        new Specification(false, new Message('d')),
      ]),
    ]);

    $this->assertFalse($compSpec->isValid());
    $invalidMessages = $compSpec->getMessages();
    $this->assertTrue(count($invalidMessages) == 2);
    $this->assertEquals('b', (string) $invalidMessages[0]);
    $this->assertEquals('d', (string) $invalidMessages[1]);
  }
}
