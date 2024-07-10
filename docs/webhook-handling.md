# Webhook handling

You can create an `Update` object by several ways:

- [from PSR-7 request](#from-psr-7-request),
- [from JSON string](#from-json-string),
- [via constructor](#via-constructor).

## From PSR-7 request

Creating `Update` object from the incoming webhook PSR-7 request:

```php
use Psr\Http\Message\ServerRequestInterface;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\Update\Update;

/**
 * @var ServerRequestInterface $request
 */

try {
    $update = Update::fromServerRequest($request);
} catch (TelegramParseResultException $e) {
    // ... 
}
```

## From JSON string

Creating `Update` object from JSON string received from POST request body:

```php
use Vjik\TelegramBot\Api\Type\Update\Update;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;

/**
 * @var string $jsonString 
 */

try {
    $update = Update::fromJson($jsonString);
} catch (TelegramParseResultException $e) {
    // ... 
}
```

## Via constructor

If needed, you can create `Update` object manually via constructor:

```php
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\Update\Update;

/**
 * @var Message $message
 */

$update = new Update(
    updateId: 33436234444,
    message: $message,
);
```
