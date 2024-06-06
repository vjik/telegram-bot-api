# Telegram Bot API for PHP

[![Latest Stable Version](https://poser.pugx.org/vjik/telegram-bot-api/v/stable.png)](https://packagist.org/packages/vjik/telegram-bot-api)
[![Total Downloads](https://poser.pugx.org/vjik/telegram-bot-api/downloads.png)](https://packagist.org/packages/vjik/telegram-bot-api)
[![Build status](https://github.com/vjik/telegram-bot-api/workflows/build/badge.svg)](https://github.com/vjik/telegram-bot-api/actions?query=workflow%3Abuild)
[![Code coverage](https://codecov.io/gh/vjik/telegram-bot-api/graph/badge.svg?token=5SV9NWKMQZ)](https://codecov.io/gh/vjik/telegram-bot-api)
[![Mutation score](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fvjik%2Ftelegram-bot-api%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/vjik/telegram-bot-api/master)
[![static analysis](https://github.com/vjik/telegram-bot-api/workflows/static%20analysis/badge.svg)](https://github.com/vjik/telegram-bot-api/actions?query=workflow%3A%22static+analysis%22)

The package provides a simple and convenient way to interact with the Telegram Bot API.

## Requirements

- PHP 8.2 or higher.

## Installation

The package could be installed with [Composer](https://getcomposer.org/download/):

```shell
composer require vjik/telegram-bot-api
```

## General usage

To make requests to the Telegram Bot API, you need to create an instance of the `TelegramBotApi` class 
that requires an instance of the `TelegramClientInterface` implementation. Out of the box, the package provides `PsrTelegramClient` based on the [PSR-18](https://www.php-fig.org/psr/psr-18/) HTTP client
and [PSR-17](https://www.php-fig.org/psr/psr-17/) HTTP factories.

For example, you can use the [php-http/curl-client](https://github.com/php-http/curl-client) and [httpsoft/http-message](https://github.com/httpsoft/http-message):

```shell
composer require php-http/curl-client httpsoft/http-message
```

In this case, `TelegramBotApi` instance will be created as follows:

```php
use Http\Client\Curl\Client;
use HttpSoft\Message\RequestFactory;
use HttpSoft\Message\ResponseFactory;
use HttpSoft\Message\StreamFactory;
use Vjik\TelegramBot\Api\Client\PsrTelegramClient;
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
    new PsrTelegramClient(
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

The result will be either `FailResult` instance (on error) or an object of the corresponding type (on success). For example:

```php
// Result is an array of `Vjik\TelegramBot\Api\Update\Update` objects
$updates = $api->getUpdates();
```

### Custom requests

Currently package contains not all methods of the Telegram Bot API. But you can make custom requests using the `send()` method and `TelegramRequest` object:

```php
use Vjik\TelegramBot\Api\Request\TelegramRequest;

$request = new TelegramRequest(
    httpMethod: HttpMethod::GET,
    apiMethod: 'getChat',
    data: ['chat_id' => '@sergei_predvoditelev'],
    successCallback: fn (mixed $result) => ChatFullInfo::fromTelegramResult($result),
);

// Result is an object of `Vjik\TelegramBot\Api\Type\ChatFullInfo`
$result = $api->send($request);
```

I'm gradually adding new methods, but you can also help with this by creating a pull request.

### Create `Update` object on webhook

You can create an `Update` object from the incoming webhook PSR-7 request:

```php
use Vjik\TelegramBot\Api\Update\Update;

try {
    $update = Update::fromServerRequest($request);
} catch (TelegramParseResultException $e) {
    // ... 
}
```

or from JSON string received from POST request body:

```php
use Vjik\TelegramBot\Api\Update\Update;

try {
    $update = Update::fromJson($jsonString);
} catch (TelegramParseResultException $e) {
    // ... 
}
```

## Documentation

- [Internals](docs/internals.md)

## License

The `vjik/telegram-bot-api` is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.

## Credits

The package is inspired by [Botasis](https://github.com/botasis) code originally created 
by [Viktor Babanov](https://github.com/viktorprogger).
