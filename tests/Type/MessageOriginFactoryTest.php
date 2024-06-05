<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\MessageOriginChannel;
use Vjik\TelegramBot\Api\Type\MessageOriginChat;
use Vjik\TelegramBot\Api\Type\MessageOriginFactory;
use Vjik\TelegramBot\Api\Type\MessageOriginHiddenUser;
use Vjik\TelegramBot\Api\Type\MessageOriginUser;

final class MessageOriginFactoryTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [
                MessageOriginUser::class,
                [
                    'type' => 'user',
                    'date' => 12412512,
                    'sender_user' => [
                        'id' => 123,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                ],
            ],
            [
                MessageOriginHiddenUser::class,
                [
                    'type' => 'hidden_user',
                    'date' => 12412512,
                    'sender_user_name' => 'John',
                ],
            ],
            [
                MessageOriginChat::class,
                [
                    'type' => 'chat',
                    'date' => 12412512,
                    'sender_chat' => [
                        'id' => 123,
                        'type' => 'private',
                    ],
                ],
            ],
            [
                MessageOriginChannel::class,
                [
                    'type' => 'channel',
                    'date' => 12412512,
                    'chat' => [
                        'id' => 123,
                        'type' => 'private',
                    ],
                    'message_id' => 99,
                ],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expectedClass, array $result): void
    {
        $result = MessageOriginFactory::fromTelegramResult($result);
        $this->assertInstanceOf($expectedClass, $result);
    }

    public function testInvalidType(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown message origin type.');
        MessageOriginFactory::fromTelegramResult([
            'type' => 'invalid',
        ]);
    }
}
