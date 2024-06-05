<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\MenuButtonCommands;
use Vjik\TelegramBot\Api\Type\MenuButtonDefault;
use Vjik\TelegramBot\Api\Type\MenuButtonFactory;
use Vjik\TelegramBot\Api\Type\MenuButtonWebApp;

final class MenuButtonFactoryTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [
                MenuButtonCommands::class,
                [
                    'type' => 'commands',
                ],
            ],
            [
                MenuButtonWebApp::class,
                [
                    'type' => 'web_app',
                    'text' => 'test',
                    'web_app' => [
                        'url' => 'https://example.com',
                    ],
                ],
            ],
            [
                MenuButtonDefault::class,
                [
                    'type' => 'default',
                ],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expectedClass, array $result): void
    {
        $result = MenuButtonFactory::fromTelegramResult($result);
        $this->assertInstanceOf($expectedClass, $result);
    }

    public function testInvalidType(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown menu button type.');
        MenuButtonFactory::fromTelegramResult([
            'type' => 'invalid',
        ]);
    }
}
