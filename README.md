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

```php
use Vjik\TelegramBot\Api\Client\PsrTelegramClient;
use Vjik\TelegramBot\Api\TelegramBotApi;
use Vjik\TelegramBot\Api\Type\InputFile

$telegramClient = new PsrTelegramClient(
    '110201543:AAHdqTcvCH1vGWJxfSeofSAs0K5PALDsaw', // Telegram bot authentication token
    $psr18HttpClient,
    $psr17RequestFactory,
    $psr17StreamFactory,
);

$api = new TelegramBotApi($telegramClient);

// Specify a URL and receive incoming updates via an outgoing webhook
$api->setWebhook('https://example.com/webhook');

// Receive incoming updates
// Result is an array of `Vjik\TelegramBot\Api\Update\Update` objects
$updates = $api->getUpdates();

// Send text message
$api->sendMessage(
    chatId: 22351, 
    text: 'Hello, world!',
);

// Send local photo
$api->sendPhoto(
    chatId: 22351, 
    photo: new InputFile(fopen('/path/to/photo.jpg', 'r')),
);
```

## Documentation

- [Internals](docs/internals.md)

## License

The `vjik/telegram-bot-api` is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.

## Credits

The package is inspired by [Botasis](https://github.com/botasis) code originally created 
by [Viktor Babanov](https://github.com/viktorprogger).
