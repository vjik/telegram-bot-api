<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests;

use Http\Client\Curl\Client;
use HttpSoft\Message\RequestFactory;
use HttpSoft\Message\ResponseFactory;
use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetChat;
use Vjik\TelegramBot\Api\Method\GetMe;
use Vjik\TelegramBot\Api\TelegramBotApi;
use Vjik\TelegramBot\Api\Client\PsrTelegramClient;
use Vjik\TelegramBot\Api\Update\DeleteWebhook;
use Vjik\TelegramBot\Api\Update\GetUpdates;
use Vjik\TelegramBot\Api\Update\GetWebhookInfo;
use Vjik\TelegramBot\Api\Update\SetWebhook;

final class TempTest extends TestCase
{
    public function test(): void
    {
        $api = new TelegramBotApi(
            new PsrTelegramClient(
                '', // Your bot token
                new Client(
                    new ResponseFactory(),
                    new StreamFactory(),
                ),
                new RequestFactory(),
                new StreamFactory(),
            ),
        );

//        $result = $api->send(new SetWebhook(url: ''));
//        $result = $api->send(new GetWebhookInfo());
//        $result = $api->send(new GetUpdates());
        $result = $api->send(new GetChat('@sergei_predvoditelev'));

        var_dump($result);
    }
}
