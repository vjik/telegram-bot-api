# Vjik Telegram Bot API

[![Latest Stable Version](https://poser.pugx.org/vjik/telegram-bot-api/v/stable.png)](https://packagist.org/packages/vjik/telegram-bot-api)
[![Total Downloads](https://poser.pugx.org/vjik/telegram-bot-api/downloads.png)](https://packagist.org/packages/vjik/telegram-bot-api)
[![Build status](https://github.com/vjik/telegram-bot-api/workflows/build/badge.svg)](https://github.com/vjik/telegram-bot-api/actions?query=workflow%3Abuild)
[![Code coverage](https://codecov.io/gh/vjik/php-telegram-bot-api/graph/badge.svg?token=5SV9NWKMQZ)](https://codecov.io/gh/vjik/php-telegram-bot-api)
[![type-coverage](https://shepherd.dev/github/vjik/telegram-bot-api/coverage.svg)](https://shepherd.dev/github/vjik/telegram-bot-api)
[![static analysis](https://github.com/vjik/telegram-bot-api/workflows/static%20analysis/badge.svg)](https://github.com/vjik/telegram-bot-api/actions?query=workflow%3A%22static+analysis%22)
[![psalm-level](https://shepherd.dev/github/vjik/telegram-bot-api/level.svg)](https://shepherd.dev/github/vjik/telegram-bot-api)

The package ...

## Requirements

- PHP 8.2 or higher.

## Installation

The package could be installed with [Composer](https://getcomposer.org/download/):

```shell
composer require vjik/telegram-bot-api
```

## General usage

## Testing

### Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```shell
./vendor/bin/phpunit
```

### Mutation testing

The package tests are checked with [Infection](https://infection.github.io/) mutation framework with
[Infection Static Analysis Plugin](https://github.com/Roave/infection-static-analysis-plugin). To run it:

```shell
./vendor/bin/roave-infection-static-analysis-plugin
```

### Static analysis

The code is statically analyzed with [Psalm](https://psalm.dev/). To run static analysis:

```shell
./vendor/bin/psalm
```

## License

The Vjik Telegram Bot API is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.

## Credits

The package is inspired by [Botasis](https://github.com/botasis) code originally created 
by [Viktor Babanov](https://github.com/viktorprogger).
