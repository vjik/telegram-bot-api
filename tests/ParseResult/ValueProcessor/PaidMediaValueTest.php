<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\ParseResult\ValueProcessor;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\PaidMediaValue;
use Vjik\TelegramBot\Api\Type\PaidMediaPhoto;
use Vjik\TelegramBot\Api\Type\PaidMediaPreview;
use Vjik\TelegramBot\Api\Type\PaidMediaVideo;

final class PaidMediaValueTest extends TestCase
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
    public function testBase(string $expectedClass, array $data): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new PaidMediaValue();

        $result = $processor->process($data, null, $objectFactory);

        $this->assertInstanceOf($expectedClass, $result);
    }

    public function testUnknown(): void
    {
        $objectFactory = new ObjectFactory();
        $processor = new PaidMediaValue();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Unknown paid media type.');
        $processor->process(['type' => 'test'], null, $objectFactory);
    }
}
