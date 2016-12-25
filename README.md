About
-----

Essential PHP-DI is a dependency injection container for PHP

Requirements
------------

Essential PHP-DI requires PHP version 7.0 or greater

Installation
------------

    $ composer require essential-php/php-di "~1.0"
    
Or alternatively, include a dependency for `essential-php/php-di` in your `composer.json` file. For example:

```json
{
    "require": {
        "essential-php/php-di": "^1.0"
    }
}
```
    
Usage
-----

```php
use Essential\Di\Container;

$container = new Container();
$container->add('foo.bar', FooBar::class)
$fooBar = $container->get('foo.bar')
```

