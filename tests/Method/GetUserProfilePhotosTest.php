<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetUserProfilePhotos;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class GetUserProfilePhotosTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetUserProfilePhotos(123);

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getUserProfilePhotos', $method->getApiMethod());
        $this->assertSame(
            [
                'user_id' => 123,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new GetUserProfilePhotos(
            123,
            1,
            2,
        );

        $this->assertSame(
            [
                'user_id' => 123,
                'offset' => 1,
                'limit' => 2,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetUserProfilePhotos(123);

        $preparedResult = TestHelper::createSuccessStubApi([
            'total_count' => 1,
            'photos' => [
                [
                    [
                        'file_id' => 'file_id',
                        'file_unique_id' => 'file_unique_id',
                        'width' => 1,
                        'height' => 2,
                        'file_size' => 3,
                    ],
                ],
            ],
        ])->send($method);

        $this->assertSame(1, $preparedResult->totalCount);
        $this->assertCount(1, $preparedResult->photos);
        $this->assertCount(1, $preparedResult->photos[0]);
        $this->assertSame('file_id', $preparedResult->photos[0][0]->fileId);
        $this->assertSame('file_unique_id', $preparedResult->photos[0][0]->fileUniqueId);
        $this->assertSame(1, $preparedResult->photos[0][0]->width);
        $this->assertSame(2, $preparedResult->photos[0][0]->height);
        $this->assertSame(3, $preparedResult->photos[0][0]->fileSize);
    }
}
