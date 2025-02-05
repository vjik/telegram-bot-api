# Custom requests

You can make custom requests to API using the `call()` method and `CustomMethod` object:

```php
use Vjik\TelegramBot\Api\CustomMethod;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ObjectValue;

/** 
 * @var \Vjik\TelegramBot\Api\TelegramBotApi $api 
 */

$method = new CustomMethod(
    apiMethod: 'getChat',
    data: ['chat_id' => '@sergei_predvoditelev'],
    resultType: new ObjectValue(ChatFullInfo::class),
    httpMethod: HttpMethod::GET,
);

// Result is an object of `Vjik\TelegramBot\Api\Type\ChatFullInfo`
$result = $api->call($method);
```
