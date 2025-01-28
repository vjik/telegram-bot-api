# Telegram Bot API for PHP

[![Latest Stable Version](https://poser.pugx.org/vjik/telegram-bot-api/v)](https://packagist.org/packages/vjik/telegram-bot-api)
[![Total Downloads](https://poser.pugx.org/vjik/telegram-bot-api/downloads)](https://packagist.org/packages/vjik/telegram-bot-api)
[![Build status](https://github.com/vjik/telegram-bot-api/actions/workflows/build.yml/badge.svg)](https://github.com/vjik/telegram-bot-api/actions/workflows/build.yml)
[![Coverage Status](https://coveralls.io/repos/github/vjik/telegram-bot-api/badge.svg)](https://coveralls.io/github/vjik/telegram-bot-api)
[![Mutation score](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fvjik%2Ftelegram-bot-api%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/vjik/telegram-bot-api/master)
[![Static analysis](https://github.com/vjik/telegram-bot-api/actions/workflows/static.yml/badge.svg?branch=master)](https://github.com/vjik/telegram-bot-api/actions/workflows/static.yml?query=branch%3Amaster)

The package provides a simple and convenient way to interact with the Telegram Bot API.

✔️ Telegram Bot API 8.2 (January 1, 2025) is **fully supported**.

## Requirements

- PHP 8.2 or higher.

## Installation

The package can be installed with [Composer](https://getcomposer.org/download/):

```shell
composer require vjik/telegram-bot-api
```

## General usage

To make requests to the Telegram Bot API, you need to create an instance of the `TelegramBotApi` class 
that requires an instance of the `TransportInterface` implementation. Out of the box, the package provides
`PsrTransport` based on the [PSR-18](https://www.php-fig.org/psr/psr-18/) HTTP client and [PSR-17](https://www.php-fig.org/psr/psr-17/) HTTP factories.

For example, you can use the [php-http/curl-client](https://github.com/php-http/curl-client) and [httpsoft/http-message](https://github.com/httpsoft/http-message):

```shell
composer require php-http/curl-client httpsoft/http-message
```

In this case, a `TelegramBotApi` instance can be created as follows:

```php
use Http\Client\Curl\Client;
use HttpSoft\Message\RequestFactory;
use HttpSoft\Message\ResponseFactory;
use HttpSoft\Message\StreamFactory;
use Vjik\TelegramBot\Api\Transport\PsrTransport;
use Vjik\TelegramBot\Api\TelegramBotApi;

// Telegram bot authentication token
$token = '110201543:AAHdqTcvCH1vGWJxfSeofSAs0K5PALDsaw';

// Dependencies
$streamFactory = new StreamFactory();
$responseFactory = new ResponseFactory();
$requestFactory = new RequestFactory();
$client = new Client($responseFactory, $streamFactory);

// API
$api = new TelegramBotApi(
    new PsrTransport(
        $token,
        $client,
        $requestFactory,
        $streamFactory,
    ),
);
```

Now you can use the `$api` instance to interact with the Telegram Bot API. Method names are the same as in the [Telegram Bot API documentation](https://core.telegram.org/bots/api). For example:

```php
use Vjik\TelegramBot\Api\Type\InputFile

// Specify a URL for outgoing webhook
$api->setWebhook('https://example.com/webhook');

// Send text message
$api->sendMessage(
    chatId: 22351, 
    text: 'Hello, world!',
);

// Send local photo
$api->sendPhoto(
    chatId: 22351, 
    photo: InputFile::fromLocalFile('/path/to/photo.jpg'),
);
```

The result will be either a `FailResult` instance (occuring on an error) or an object of the corresponding type (occuring on success). For example:

```php
// Result is an array of `Vjik\TelegramBot\Api\Update\Update` objects
$updates = $api->getUpdates();
```

## Documentation

- [Logging](docs/logging.md)
- [Webhook handling](docs/webhook-handling.md)
- [Custom requests](docs/custom-requests.md)
- [Internals](docs/internals.md)

If you have any questions or problems with this package, use [author telegram chat](https://t.me/predvoditelev_chat) for communication.

## License

The `vjik/telegram-bot-api` is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.

## Credits

The package is inspired by [Botasis](https://github.com/botasis) code originally created 
by [Viktor Babanov](https://github.com/viktorprogger).
