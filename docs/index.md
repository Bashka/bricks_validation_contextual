# Введение

Данный пакет служит для организации контекстной валидации объектов с помощью внутренних или внешних спецификаций. Спецификации описываются интерфейсом _SpecificationInterface_ и агрегируют сообщения о нарушении спецификации, которые могут быть предоставлены методом _getMessages_. Перед вызовом данного метода необходимо выполнить валидацию через вызов _isValid_.

Сообщения о нарушении спецификации представляются в виде экземпляров класса, реализующего _MessageInterface_. В качестве базовой реализации может использоваться класс _Message_, хранящий текст о нарушении в виде строки.

Базовым классом для контекстной валидации является _Specification_, использующий внешнюю валидацию и служащий простым хранилищем сообщений:

```php
use Bricks\Validation\Contextual\Specification;

$spec = new Specification(!empty($email), new Message('Необходимо указать email.'));

if(!$spec->isValid()){
    return $spec->getMessages();
}
```

Класс _CompositeSpecification_ позволяет агрегировать спецификации и использовать их для валидации:

```php
use Bricks\Validation\Contextual\Specification;
use Bricks\Validation\Contextual\CompositeSpecification;

$spec = new CompositeSpecification(
    new Specification(!empty($email), new Message('Необходимо указать email.')),
    new Specification(!empty($password), new Message('Необходимо указать password.'))
);

if(!$spec->isValid()){
    return $spec->getMessages();
}
```

# Синтаксический сахар

Для упрощения интерфейса формирования спецификаций может использоваться класс _Spec_, включающий два статичных метода:

  * _is_ - формирование экземпляра _Specification_
  * _compos_ - формирование экземпляра _CompositeSpecification_

```php
use Bricks\Validation\Contextual\Spec;

$spec = Spec::compos(
    Spec::is(!empty($email), 'Необходимо указать email.'),
    // Пример вложенной композитной спецификации.
    Spec::compos(
        Spec::is(!empty($login), 'Необходимо указать login.'),
        Spec::is(!empty($pass), 'Необходимо указать password.')
    )
);
```

# Контекстная валидация состояния объекта

Рекомендуется использовать механизм контекстной валидации для проверки состояния объекта перед его использованием. Для этого достаточно включить методы валидации в тело класса следующим образом:

```php
use Bricks\Validation\Contextual\Spec;

class User{
    private $id;
    private $login;
    private $password;

    ...

    // Метод контекстной валидации, позволяющей проверить готовность объекта к сохранению
    public function isPersist(){
        return Spec::compos(
            Spec::is(!empty($this->id), 'Не указан идентификатор объекта'),
            Spec::is(!empty($this->login), 'Не указан логин пользователя'),
            Spec::is(!empty($this->password), 'Не указан пароль пользователя')
        );
    }
}
```

Такая организация позволяет выполнить проверку состояния объекта перед его сохранением и выявить все нарушения спецификации:

```php
public function saveUser(User $user){
    $persistSpec = $user->isPersist();
    if(!$persistSpec->isValid()){
        return $persistSpec->getMessages();
    }

    ...
}
```

# Собственные спецификации

Интерфейс _SpecificationInterface_ позволяет сформировать набор собственных спецификаций:

```php
use Bricks\Validation\Contextual\Specification;
use Bricks\Validation\Contextual\Message\Message;
use Bricks\Validation\Contextual\CompositeSpecification;
use Bricks\Validation\Contextual\Spec;

class PersistSpec extends Specification{
    public function __construct($id){
        parent::__construct(!empty($id), new Message('Не указан идентификатор объекта.'));
    }
}

class UserPersistSpec extends CompositeSpecification{
    public function __construct($id, $login, $password){
        parent::__construct([
            new PersistSpec($id),
            Spec::is(!empty($login), 'Не указан логин пользователя.'),
            Spec::is(!empty($password), 'Не указан пароль пользователя.')
        ]);
    }
}
```

Такая, внешняя спецификация, может использоваться внутри валидируемого объекта:

```php
class User{
    private $id;
    private $login;
    private $password;

    ...

    public function isPersist(){
        return new UserPersistSpec($this->id, $this->login, $this->password);
    }
}
```
