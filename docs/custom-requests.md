# Custom requests

You can make custom requests to API using the `call()` method and `Method` object:

```php
use Vjik\TelegramBot\Api\Method;

/** 
 * @var \Vjik\TelegramBot\Api\TelegramBotApi $api 
 */

$request = new Method(
    apiMethod: 'getChat',
    data: ['chat_id' => '@sergei_predvoditelev'],
    resultType: ChatFullInfo::class,
    httpMethod: HttpMethod::GET,
);

// Result is an object of `Vjik\TelegramBot\Api\Type\ChatFullInfo`
$result = $api->call($request);
```
