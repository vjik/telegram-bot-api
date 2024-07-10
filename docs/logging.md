# Logging

You can use any [PSR-3](https://www.php-fig.org/psr/psr-3/) compatible logger to log requests to Telegram Bot API and
response handling errors. For example, [Monolog](https://github.com/Seldaek/monolog) or
[Yii Log](https://github.com/yiisoft/log).

Pass logger to `TelegramBotApi` constructor:

```php
use Psr\Log\LoggerInterface;
use Vjik\TelegramBot\Api\Client\TelegramClientInterface;
use Vjik\TelegramBot\Api\TelegramBotApi;

/**
 * @var TelegramClientInterface $telegramClient
 * @var LoggerInterface $logger
 */

// API
$api = new TelegramBotApi($telegramClient, $logger);
```

You can use logger on create `Update` object also:

```php
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Vjik\TelegramBot\Api\Type\Update\Update;

/**
 * @var ServerRequestInterface $request
 * @var string $jsonString
 * @var LoggerInterface $logger
 */

$update = Update::fromServerRequest($request, $logger);
$update = Update::fromJson($jsonString, $logger);
```

