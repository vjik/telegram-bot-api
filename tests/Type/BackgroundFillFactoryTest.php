<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\BackgroundFillFactory;
use Vjik\TelegramBot\Api\Type\BackgroundFillFreeformGradient;
use Vjik\TelegramBot\Api\Type\BackgroundFillGradient;
use Vjik\TelegramBot\Api\Type\BackgroundFillSolid;

final class BackgroundFillFactoryTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [
                BackgroundFillSolid::class,
                [
                    'type' => 'solid',
                    'color' => 0x000000
                ],
            ],
            [
                BackgroundFillGradient::class,
                [
                    'type' => 'gradient',
                    'top_color' => 0x000000,
                    'bottom_color' => 0xFFFFFF,
                    'rotation_angle' => 19,
                ],
            ],
            [
                BackgroundFillFreeformGradient::class,
                [
                    'type' => 'freeform_gradient',
                    'colors' => [0x000000, 0xFFFFFF],
                ],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expectedClass, array $result): void
    {
        $result = BackgroundFillFactory::fromTelegramResult($result);
        $this->assertInstanceOf($expectedClass, $result);
    }

    public function testInvalidType(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown background fill type.');
        BackgroundFillFactory::fromTelegramResult([
            'type' => 'invalid',
        ]);
    }
}
