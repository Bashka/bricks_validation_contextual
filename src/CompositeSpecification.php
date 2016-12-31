<?php
namespace Bricks\Validation\Contextual;

use InvalidArgumentException;

/**
 * @author Artur Sh. Mamedbekov
 */
class CompositeSpecification extends AbstractSpecification{
  /**
   * @var SpecificationInterface[] Входящие в композит спецификации.
   */
  protected $specifications;

  /**
   * @var bool Валидна ли спецификация композита в целом.
   */
  private $isValid;
  
  /**
   * @param SpecificationInterface[] $specifications Спецификации, составляющие 
   * композицию.
   *
   * @throws InvalidArgumentException
   */
  public function __construct(array $specifications){
    foreach($specifications as $spec){
      if(!$spec instanceof SpecificationInterface){
        throw new InvalidArgumentException(sprintf(
          'Composite specification should contain %s, %s given',
          SpecificationInterface::class,
          is_object($spec)? get_class($spec) : gettype($spec)
        ));
      }
    }

    $this->specifications = $specifications;
  }

  /**
   * {@inheritdoc}
   */
  public function isValid(){
    if(!is_bool($this->isValid)){
      $this->isValid = true;

      foreach($this->specifications as $spec){
        if($spec->isValid()){
          continue;
        }

        $this->messages = array_merge($this->messages, $spec->getMessages());
        $this->isValid = false;
      }
    }

    return $this->isValid;
  }
}
