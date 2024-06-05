<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\ReactionTypeCustomEmoji;
use Vjik\TelegramBot\Api\Type\ReactionTypeEmoji;
use Vjik\TelegramBot\Api\Type\ReactionTypeFactory;

final class ReactionTypeFactoryTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [
                ReactionTypeEmoji::class,
                [
                    'type' => 'emoji',
                    'emoji' => '👍',
                ],
            ],
            [
                ReactionTypeCustomEmoji::class,
                [
                    'type' => 'custom_emoji',
                    'custom_emoji_id' => '124',
                ],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expectedClass, array $result): void
    {
        $result = ReactionTypeFactory::fromTelegramResult($result);
        $this->assertInstanceOf($expectedClass, $result);
    }

    public function testInvalidType(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown reaction type.');
        ReactionTypeFactory::fromTelegramResult([
            'type' => 'invalid',
        ]);
    }
}
