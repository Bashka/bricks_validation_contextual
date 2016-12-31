<?php
namespace Bricks\Validation\Contextual\UnitTest;

use PHPUnit_Framework_TestCase;
use Bricks\Validation\Contextual\Spec;
use Bricks\Validation\Contextual\Message\Message;
use Bricks\Validation\Contextual\Specification;
use Bricks\Validation\Contextual\CompositeSpecification;

/**
 * @author Artur Sh. Mamedbekov
 */
class SpecTest extends PHPUnit_Framework_TestCase{
  public function testIs(){
    $validSpec = Spec::is(true, 'valid');
    $invalidSpec = Spec::is(false, new Message('invalid'));

    $this->assertInstanceOf(Specification::class, $validSpec);
    $this->assertTrue($validSpec->isValid());
    $this->assertFalse($invalidSpec->isValid());
    $this->assertEquals([], $validSpec->getMessages());
    $this->assertEquals('invalid', (string) $invalidSpec->getMessages()[0]);
  }

  public function testCompos(){
    $compos = Spec::compos(
      Spec::is(true, 'valid'),
      Spec::is(false, 'invalid1'),
      Spec::compos(
        Spec::is(true, 'valid'),
        Spec::is(false, 'invalid2')
      )
    );

    $this->assertInstanceOf(CompositeSpecification::class, $compos);
    $this->assertFalse($compos->isValid());
    $invalidMessages = $compos->getMessages();
    $this->assertTrue(count($invalidMessages) == 2);
    $this->assertEquals('invalid1', (string) $invalidMessages[0]);
    $this->assertEquals('invalid2', (string) $invalidMessages[1]);
  }
}
