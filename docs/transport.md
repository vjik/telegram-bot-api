# Transport

`TelegramBotApi` requires a transport implementation to make requests to the Telegram Bot API. Out of the box, available two transport implementations: cURL and PSR.

## cURL

The `CurlTransport` class is a transport implementation for making requests to the Telegram Bot API using the cURL extension in PHP. This transport is often the easiest choice since the cURL extension is included in most PHP installations.

General usage:

```php
use Vjik\TelegramBot\Api\TelegramBotApi;
use Vjik\TelegramBot\Api\Transport\Curl\CurlTransport;

$transport = new CurlTransport(
    // Telegram bot authentication token
    '110201543:AAHdqTcvCH1vGWJxfSeofSAs0K5PALDsaw'
);

$api = new TelegramBotApi($transport);
```

Constructor parameters:

- `$token` — Telegram bot authentication token;
- `$baseUrl` — the base URL for Telegram Bot API requests (default `https://api.telegram.org`).

## PSR

PSR transport requires the [PSR-18](https://www.php-fig.org/psr/psr-18/) HTTP client and [PSR-17](https://www.php-fig.org/psr/psr-17/) HTTP factories.

For example, you can use the [php-http/curl-client](https://github.com/php-http/curl-client) and [httpsoft/http-message](https://github.com/httpsoft/http-message):

```shell
composer require php-http/curl-client httpsoft/http-message
```

General usage:

```php
use Http\Client\Curl\Client;
use HttpSoft\Message\RequestFactory;
use HttpSoft\Message\ResponseFactory;
use HttpSoft\Message\StreamFactory;
use Vjik\TelegramBot\Api\TelegramBotApi;
use Vjik\TelegramBot\Api\Transport\PsrTransport;

$streamFactory = new StreamFactory();
$responseFactory = new ResponseFactory();
$requestFactory = new RequestFactory();
$client = new Client($responseFactory, $streamFactory);

$transport = new PsrTransport(
    $token,
    $client,
    $requestFactory,
    $streamFactory,
);

$api = new TelegramBotApi($transport);
```

Constructor parameters:

- `$token` — Telegram bot authentication token;
- `$client` — PSR-18 HTTP client;
- `$requestFactory` — PSR-17 HTTP request factory;
- `$streamFactory` — PSR-17 HTTP stream factory;
- `$baseUrl` — the base URL for Telegram Bot API requests (default `https://api.telegram.org`).

