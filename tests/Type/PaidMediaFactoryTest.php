<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\PaidMediaFactory;
use Vjik\TelegramBot\Api\Type\PaidMediaPhoto;
use Vjik\TelegramBot\Api\Type\PaidMediaPreview;
use Vjik\TelegramBot\Api\Type\PaidMediaVideo;

final class PaidMediaFactoryTest extends TestCase
{
    public static function dataBase(): array
    {
        return [
            [
                PaidMediaPreview::class,
                [
                    'type' => 'preview',
                    'width' => 100,
                    'height' => 100,
                    'duration' => 23,
                ],
            ],
            [
                PaidMediaPhoto::class,
                [
                    'type' => 'photo',
                    'photo' => [],
                ],
            ],
            [
                PaidMediaVideo::class,
                [
                    'type' => 'video',
                    'video' => [
                        'file_id' => 'f12',
                        'file_unique_id' => 'fu12',
                        'width' => 100,
                        'height' => 200,
                        'duration' => 23,
                    ],
                ],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(string $expectedClass, array $result): void
    {
        $result = PaidMediaFactory::fromTelegramResult($result);
        $this->assertInstanceOf($expectedClass, $result);
    }

    public function testInvalidType(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown paid media type.');
        PaidMediaFactory::fromTelegramResult([
            'type' => 'invalid',
        ]);
    }
}
