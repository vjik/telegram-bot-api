<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\ChatBoostSourceFactory;
use Vjik\TelegramBot\Api\Type\ChatBoostSourceGiftCode;
use Vjik\TelegramBot\Api\Type\ChatBoostSourceGiveaway;
use Vjik\TelegramBot\Api\Type\ChatBoostSourcePremium;

final class ChatBoostSourceFactoryTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [
                ChatBoostSourcePremium::class,
                [
                    'source' => 'premium',
                    'user' => [
                        'id' => 123,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                ],
            ],
            [
                ChatBoostSourceGiftCode::class,
                [
                    'source' => 'gift_code',
                    'user' => [
                        'id' => 123,
                        'is_bot' => false,
                        'first_name' => 'John',
                    ],
                ],
            ],
            [
                ChatBoostSourceGiveaway::class,
                [
                    'source' => 'giveaway',
                    'giveaway_message_id' => 12,
                ],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expectedClass, array $result): void
    {
        $result = ChatBoostSourceFactory::fromTelegramResult($result);
        $this->assertInstanceOf($expectedClass, $result);
    }

    public function testInvalidType(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown chat boost source.');
        ChatBoostSourceFactory::fromTelegramResult([
            'source' => 'invalid',
        ]);
    }
}
