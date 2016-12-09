# lumen-chained-exception-handler

[![Build Status](https://travis-ci.org/nordsoftware/lumen-chained-exception-handler.svg?branch=travis)](https://travis-ci.org/nordsoftware/lumen-chained-exception-handler)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nordsoftware/lumen-chained-exception-handler/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nordsoftware/lumen-chained-exception-handler/?branch=master)
[![Coverage Status](https://coveralls.io/repos/github/nordsoftware/lumen-chained-exception-handler/badge.svg?branch=travis)](https://coveralls.io/github/nordsoftware/lumen-chained-exception-handler?branch=travis)

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

Add the following lines to ```bootstrap/app.php```:

```php
$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    new Nord\Lumen\ChainedExceptionHandler\ChainedExceptionhandler(
        new App\Exceptions\Handler()
    )
);
```

The constructor takes two parameters, a primary exception handler and an optional array of secondary handlers. The 
`report()` method will be called on all handlers, but the `render()` and `renderForConsole()` methods will only be 
called on the primary handler.

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
