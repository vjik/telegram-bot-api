# Custom requests

You can make custom requests using the `send()` method and `TelegramRequest` object:

```php
use Vjik\TelegramBot\Api\Request\TelegramRequest;

$request = new TelegramRequest(
    httpMethod: HttpMethod::GET,
    apiMethod: 'getChat',
    data: ['chat_id' => '@sergei_predvoditelev'],
    resultType: ChatFullInfo::class,
);

// Result is an object of `Vjik\TelegramBot\Api\Type\ChatFullInfo`
$result = $api->send($request);
```
