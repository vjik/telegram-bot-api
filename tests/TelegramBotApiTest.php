<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Client\TelegramResponse;
use Vjik\TelegramBot\Api\FailResult;
use Vjik\TelegramBot\Api\InvalidResponseFormatException;
use Vjik\TelegramBot\Api\Method\GetMe;
use Vjik\TelegramBot\Api\TelegramBotApi;
use Vjik\TelegramBot\Api\Tests\Support\StubTelegramClient;
use Vjik\TelegramBot\Api\Type\ChatFullInfo;
use Vjik\TelegramBot\Api\Type\MenuButtonDefault;
use Vjik\TelegramBot\Api\Type\User;

final class TelegramBotApiTest extends TestCase
{
    public function testSendSuccess(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Sergei',
            ],
        ]);

        $result = $api->send(new GetMe());

        $this->assertInstanceOf(User::class, $result);
        $this->assertSame(1, $result->id);
    }

    public function testSendFail(): void
    {
        $api = $this->createApi([
            'ok' => false,
            'description' => 'test error',
        ]);

        $result = $api->send(new GetMe());

        $this->assertInstanceOf(FailResult::class, $result);
        $this->assertSame('test error', $result->description);
    }

    public function testSuccessResponseWithoutResult(): void
    {
        $api = $this->createApi([
            'ok' => true,
        ]);

        $this->expectException(InvalidResponseFormatException::class);
        $this->expectExceptionMessage('Not found "result" field in response. Status code: 200.');
        $api->send(new GetMe());
    }

    public function testResponseWithInvalidJson(): void
    {
        $api = $this->createApi('g {12}');

        $this->expectException(InvalidResponseFormatException::class);
        $this->expectExceptionMessage('Failed to decode JSON response. Status code: 200.');
        $api->send(new GetMe());
    }

    public function testNotArrayResponse(): void
    {
        $api = $this->createApi('"hello"');

        $this->expectException(InvalidResponseFormatException::class);
        $this->expectExceptionMessage('Expected telegram response as array. Got "string".');
        $api->send(new GetMe());
    }

    public function testResponseWithNotBooleanOk(): void
    {
        $api = $this->createApi([
            'ok' => 'true',
        ]);

        $this->expectException(InvalidResponseFormatException::class);
        $this->expectExceptionMessage('Incorrect "ok" field in response. Status code: 200.');
        $api->send(new GetMe());
    }

    public function testDeleteMyCommands(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->deleteMyCommands();

        $this->assertTrue($result);
    }

    public function testDeleteWebhook(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => true,
        ]);

        $result = $api->deleteWebhook();

        $this->assertTrue($result);
    }

    public function testGetChat(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'id' => 23,
                'type' => 'private',
                'accent_color_id' => 0x123456,
                'max_reaction_count' => 5,
            ],
        ]);

        $result = $api->getChat(23);

        $this->assertInstanceOf(ChatFullInfo::class, $result);
        $this->assertSame(23, $result->id);
    }

    public function testGetChatMenuButton(): void
    {
        $api = $this->createApi([
            'ok' => true,
            'result' => [
                'type' => 'default',
            ],
        ]);

        $result = $api->getChatMenuButton();

        $this->assertInstanceOf(MenuButtonDefault::class, $result);
    }

    private function createApi(array|string $response, int $statusCode = 200): TelegramBotApi
    {
        return new TelegramBotApi(
            new StubTelegramClient(
                new TelegramResponse(
                    $statusCode,
                    is_array($response) ? json_encode($response) : $response,
                )
            )
        );
    }
}
