<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\BackgroundTypeValue;
use Vjik\TelegramBot\Api\Type\BackgroundTypeChatTheme;
use Vjik\TelegramBot\Api\Type\BackgroundTypeFill;
use Vjik\TelegramBot\Api\Type\BackgroundTypePattern;
use Vjik\TelegramBot\Api\Type\BackgroundTypeWallpaper;

final class BackgroundTypeValueTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [
                BackgroundTypeFill::class,
                [
                    'type' => 'fill',
                    'fill' => [
                        'type' => 'solid',
                        'color' => 0x000000
                    ],
                    'dark_theme_dimming' => 95,
                ],
            ],
            [
                BackgroundTypeWallpaper::class,
                [
                    'type' => 'wallpaper',
                    'document' => [
                        'file_id' => 'f123',
                        'file_unique_id' => 'full123',
                    ],
                    'dark_theme_dimming' => 99,
                ],
            ],
            [
                BackgroundTypePattern::class,
                [
                    'type' => 'pattern',
                    'document' => [
                        'file_id' => 'f123',
                        'file_unique_id' => 'full123',
                    ],
                    'fill' => [
                        'type' => 'solid',
                        'color' => 0x000000
                    ],
                    'intensity' => 5,
                ],
            ],
            [
                BackgroundTypeChatTheme::class,
                [
                    'type' => 'chat_theme',
                    'theme_name' => 'dark',
                ],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expectedClass, array $data): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new BackgroundTypeValue();

        $result = $processor->process($data, null, $objectFactory);

        $this->assertInstanceOf($expectedClass, $result);
    }

    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new BackgroundTypeValue();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown background type.');
        $processor->process(['type' => 'test'], null, $objectFactory);
    }
}
