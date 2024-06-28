<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\RealTelegramApi;

use Http\Client\Curl\Client;
use HttpSoft\Message\RequestFactory;
use HttpSoft\Message\ResponseFactory;
use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Client\PsrTelegramClient;
use Vjik\TelegramBot\Api\TelegramBotApi;

/**
 * @group realApi
 */
final class RealTelegramApiTest extends TestCase
{
    private const TOKEN = '';

    public function testBase(): void
    {
        $api = $this->createApi();

        $result = $api->getChat('@sergei_predvoditelev');

        var_dump($result);
    }

    private function createApi(): TelegramBotApi
    {
        $streamFactory = new StreamFactory();
        return new TelegramBotApi(
            new PsrTelegramClient(
                self::TOKEN,
                new Client(
                    new ResponseFactory(),
                    $streamFactory,
                ),
                new RequestFactory(),
                $streamFactory,
            ),
        );
    }
}
