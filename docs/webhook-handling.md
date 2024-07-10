# Webhook handling

## `Update` object

You can create an `Update` object by several ways:

- [from PSR-7 request](#from-psr-7-request),
- [from JSON string](#from-json-string),
- [via constructor](#via-constructor).

If `Update` created by `fromJson()` or `fromServerRequest()` method, you can get raw data via `getRaw()` method:

```php
/**
 * @var Vjik\TelegramBot\Api\Type\Update\Update $update 
 */
 
/**
 * @var string $raw Raw data, for example:
 *
 * {"update_id":33991112,"message":{"message_id":422,"from":{"id":1234567,"is_bot":false,"first_name":"John","last_name":"Doe","username":"john_doe","language_code":"ru","is_premium":true},"chat":{"id":1234567,"first_name":"John","last_name":"Doe","username":"john_doe","type":"private"},"date":1720523588,"text":"Hello!"}}
 */
$raw = $update->getRaw();

/**
 * @var array $raw Decoded raw data, for example:
 *
 * [
 *    'update' => 33991112,
 *    'message' => [
 *        'message_id' => 422,
 *        'from' => [
 *            'id' => 1234567,
 *            'is_bot' => false,
 *            'first_name' => 'John',
 *            'last_name' => 'Doe',
 *            'username' => 'john_doe',
 *            'language_code' => 'ru',
 *            'is_premium' => true,
 *        ],
 *        'chat' => [
 *            'id' => 1234567,
 *            'first_name' => 'John',
 *            'last_name' => 'Doe',
 *            'username' => 'john_doe',
 *            'type' => 'private',
 *        ],
 *        'date' => 1720523588,
 *        'text' => 'Hello!'
 *    ],
 * ]
 */
$raw = $update->getRaw(decoded: true);
```

### From PSR-7 request

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

### From JSON string

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

### Via constructor

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
