# lumen-chained-exception-handler

[![Build Status](https://travis-ci.org/digiaonline/lumen-chained-exception-handler.svg?branch=travis)](https://travis-ci.org/digiaonline/lumen-chained-exception-handler)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/digiaonline/lumen-chained-exception-handler/badges/quality-score.png?b=develop)](https://scrutinizer-ci.com/g/digiaonline/lumen-chained-exception-handler/?branch=develop)
[![Coverage Status](https://coveralls.io/repos/github/digiaonline/lumen-chained-exception-handler/badge.svg?branch=develop)](https://coveralls.io/github/digiaonline/lumen-chained-exception-handler?branch=develop)
[![Code Climate](https://codeclimate.com/github/digiaonline/lumen-chained-exception-handler/badges/gpa.svg)](https://codeclimate.com/github/digiaonline/lumen-chained-exception-handler)

This utility allows you to chain together multiple exception handlers in your Lumen application. This can be useful if 
you want to use the rendering capabilities of the default exception handler, but you want to use the reporting logic 
from a third-party exception handler. The reporting logic can usually be extended by adding another Monolog handler, 
but all exceptions will be mangled into strings which is not always feasible.

## Installation

Run the following command to install the package through Composer:

```sh
composer require nordsoftware/lumen-chained-exception-handler
```

## Usage

Replace the `$app->singleton()` call which registers the concrete exception handler in `bootstrap/app.php` with the 
following:

```php
$app->instance(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    new Nord\Lumen\ChainedExceptionHandler\ChainedExceptionhandler(
        new App\Exceptions\Handler()
    )
);
```

The constructor takes two parameters, a primary exception handler and an optional array of secondary handlers. The 
`report()` method will be called on all handlers, but the `render()` and `renderForConsole()` methods will only be 
called on the primary handler.

For example, if want to use the default `Laravel\Lumen\Exceptions\Handler` as your primary error handler and 
`Foo\Bar\ExceptionHandler` and `Baz\ExceptionHandler` as secondary exception handlers, you would use this:

```php
$app->instance(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    new Nord\Lumen\ChainedExceptionHandler\ChainedExceptionhandler(
        new Laravel\Lumen\Exceptions\Handler(),
        [new Foo\Bar\ExceptionHandler(), new Baz\ExceptionHandler()]
    )
);
```

## Running tests

Clone the project and install its dependencies by running:

```sh
composer install
```

Run the following command to run the test suite:

```sh
vendor/bin/phpunit
```

## License

See [LICENSE](LICENSE)
