# Internals

## Manual testing with real telegram bot API

- Open directory `/tests/RealTelegramApi/`.
- Copy `token.dist.php` to `token.php`.
- Add your bot authentication token to `token.php`, for example:

```php
<?php

declare(strict_types=1);

return '110201543:AAHdqTcvCH1vGWJxfSeofSAs0K5PALDsaw';
```

- Put your test code into `testBase()` method in `RealTelegramApiTest.php`.
- Run tests with real Telegram bot API via PHPUnit:

```shell
./vendor/bin/phpunit --group=realApi
```

## Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```shell
./vendor/bin/phpunit
```

## Mutation testing

The package tests are checked with [Infection](https://infection.github.io/) mutation framework with
[Infection Static Analysis Plugin](https://github.com/Roave/infection-static-analysis-plugin). To run it:

```shell
./vendor/bin/roave-infection-static-analysis-plugin
```

## Static analysis

The code is statically analyzed with [Psalm](https://psalm.dev/). To run static analysis:

```shell
./vendor/bin/psalm
```

## Dependencies

Use [ComposerRequireChecker](https://github.com/maglnet/ComposerRequireChecker) to detect transitive
[Composer](https://getcomposer.org) dependencies:

```shell
./vendor/bin/composer-require-checker
```
