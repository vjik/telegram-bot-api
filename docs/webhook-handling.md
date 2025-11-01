# Webhook handling

This guide explains how to handle incoming webhook updates from Telegram and how to respond to them.

## `Update` object

You can create an `Update` object by several ways:

- [from PSR-7 request](#from-psr-7-request),
- [from JSON string](#from-json-string),
- [via constructor](#via-constructor).

If `Update` created by `fromJson()` or `fromServerRequest()` method, you can get raw data via `getRaw()` method:

```php
/**
 * @var Phptg\BotApi\Type\Update\Update $update 
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
use Phptg\BotApi\ParseResult\TelegramParseResultException;
use Phptg\BotApi\Type\Update\Update;

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
use Phptg\BotApi\Type\Update\Update;
use Phptg\BotApi\ParseResult\TelegramParseResultException;

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
use Phptg\BotApi\Type\Message;
use Phptg\BotApi\Type\Update\Update;

/**
 * @var Message $message
 */

$update = new Update(
    updateId: 33436234444,
    message: $message,
);
```

## Webhook responses

According to the Telegram Bot API 
[documentation](https://core.telegram.org/bots/faq#how-can-i-make-requests-in-response-to-updates),
you can respond to webhook updates by returning a JSON-serialized method in the HTTP response body. This allows you to
make one Bot API request without waiting for a response from your server.

### Creating webhook responses

The `WebhookResponse` class represents a method as a response to a webhook. You can create it from any method object:

```php
use Phptg\BotApi\Method\SendMessage;
use Phptg\BotApi\WebhookResponse\WebhookResponse;

$method = new SendMessage(chatId: 12345, text: 'Hello!');
$webhookResponse = new WebhookResponse($method);

// Check if the method is supported for webhook responses (doesn't use InputFile)
if ($webhookResponse->isSupported()) {
    $data = $webhookResponse->getData();
    // Returns: ['method' => 'sendMessage', 'chat_id' => 12345, 'text' => 'Hello!']
}
```

### PSR-7 response factory

The `PsrWebhookResponseFactory` creates PSR-7 compliant HTTP responses for webhook handlers:

```php
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Phptg\BotApi\Method\SendMessage;
use Phptg\BotApi\WebhookResponse\PsrWebhookResponseFactory;
use Phptg\BotApi\WebhookResponse\WebhookResponse;

/**
 * @var ResponseFactoryInterface $responseFactory
 * @var StreamFactoryInterface $streamFactory
 */

$factory = new PsrWebhookResponseFactory($responseFactory, $streamFactory);

// Create response from WebhookResponse object
$webhookResponse = new WebhookResponse(new SendMessage(chatId: 12345, text: 'Hello!'));
$response = $factory->create($webhookResponse);

// Or create response directly from method, if you are sure that InputFile is not used
$method = new SendMessage(chatId: 12345, text: 'Hello!');
$response = $factory->byMethod($method);
```

The factory automatically:

- encodes the data as JSON;
- sets the `Content-Type` header to `application/json; charset=utf-8`;
- sets the `Content-Length` header.

### JSON response factory

The `JsonWebhookResponseFactory` creates JSON strings for webhook responses:

```php
use Phptg\BotApi\Method\SendMessage;
use Phptg\BotApi\WebhookResponse\JsonWebhookResponseFactory;
use Phptg\BotApi\WebhookResponse\WebhookResponse;

$factory = new JsonWebhookResponseFactory();

// Create JSON from WebhookResponse object
$webhookResponse = new WebhookResponse(new SendMessage(chatId: 12345, text: 'Hello!'));
$json = $factory->create($webhookResponse);

// Or create JSON directly from method
$method = new SendMessage(chatId: 12345, text: 'Hello!');
$json = $factory->byMethod($method);

// Now you can send this JSON in your HTTP response body
header('Content-Type: application/json; charset=utf-8');
echo $json;
```

### Limitations

Webhook responses have an important limitation: they **do not support file uploads** (methods using `InputFile`).
This is because webhook responses are sent as JSON, and file uploads require multipart form data.

If you try to create a webhook response with a method that uses `InputFile`, the following will happen:

- `isSupported()` will return `false`;
- `getData()` will throw `MethodNotSupportedException`.

```php
use Phptg\BotApi\Method\SendPhoto;
use Phptg\BotApi\Type\InputFile;
use Phptg\BotApi\WebhookResponse\WebhookResponse;
use Phptg\BotApi\WebhookResponse\MethodNotSupportedException;

$method = new SendPhoto(
    chatId: 12345,
    photo: InputFile::fromLocalFile('/path/to/photo.jpg'),
);

$webhookResponse = new WebhookResponse($method);

if (!$webhookResponse->isSupported()) {
    // Method contains InputFile - cannot be sent via webhook response
    // You'll need to make a separate API call for this
}

try {
    $data = $webhookResponse->getData();
} catch (MethodNotSupportedException $e) {
    // Exception: "InputFile is not supported in Webhook response."
}
```

For methods with file uploads, you must use the regular `TelegramBotApi` instance to make the request separately.
