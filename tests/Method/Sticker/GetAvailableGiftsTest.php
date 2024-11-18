<?php

declare(strict_types=1);

namespace Method\Sticker;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\GetAvailableGifts;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class GetAvailableGiftsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetAvailableGifts();

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getAvailableGifts', $method->getApiMethod());
        $this->assertSame([], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetAvailableGifts();

        $preparedResult = TestHelper::createSuccessStubApi([
            'gifts' => [
                [
                    'id' => 'test-id1',
                    'sticker' => [
                        'file_id' => 'x1',
                        'file_unique_id' => 'fullX1',
                        'type' => 'regular',
                        'width' => 100,
                        'height' => 120,
                        'is_animated' => false,
                        'is_video' => true,
                    ],
                    'star_count' => 11,
                ],
                [
                    'id' => 'test-id2',
                    'sticker' => [
                        'file_id' => 'x1',
                        'file_unique_id' => 'fullX1',
                        'type' => 'regular',
                        'width' => 100,
                        'height' => 120,
                        'is_animated' => false,
                        'is_video' => true,
                    ],
                    'star_count' => 11,
                ],
            ],
        ])->send($method);

        $this->assertCount(2, $preparedResult->gifts);
    }
}
