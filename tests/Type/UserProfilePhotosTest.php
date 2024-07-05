<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\UserProfilePhotos;

final class UserProfilePhotosTest extends TestCase
{
    public function testBase(): void
    {
        $userProfilePhotos = new UserProfilePhotos(5, []);

        $this->assertSame(5, $userProfilePhotos->totalCount);
        $this->assertSame([], $userProfilePhotos->photos);
    }

    public function testFromTelegramResult(): void
    {
        $userProfilePhotos = (new ObjectFactory())->create([
            'total_count' => 1,
            'photos' => [
                [
                    [
                        'file_id' => 'file_id_1',
                        'file_unique_id' => 'file_unique_id_1',
                        'width' => 100,
                        'height' => 200,
                        'file_size' => 300,
                    ],
                    [
                        'file_id' => 'file_id_2',
                        'file_unique_id' => 'file_unique_id_2',
                        'width' => 400,
                        'height' => 500,
                        'file_size' => 600,
                    ],
                ],
            ],
        ], null, UserProfilePhotos::class);

        $this->assertSame(1, $userProfilePhotos->totalCount);

        $this->assertCount(1, $userProfilePhotos->photos);
        $this->assertCount(2, $userProfilePhotos->photos[0]);

        $this->assertSame('file_id_1', $userProfilePhotos->photos[0][0]->fileId);
        $this->assertSame('file_unique_id_1', $userProfilePhotos->photos[0][0]->fileUniqueId);
        $this->assertSame(100, $userProfilePhotos->photos[0][0]->width);
        $this->assertSame(200, $userProfilePhotos->photos[0][0]->height);
        $this->assertSame(300, $userProfilePhotos->photos[0][0]->fileSize);

        $this->assertSame('file_id_2', $userProfilePhotos->photos[0][1]->fileId);
        $this->assertSame('file_unique_id_2', $userProfilePhotos->photos[0][1]->fileUniqueId);
        $this->assertSame(400, $userProfilePhotos->photos[0][1]->width);
        $this->assertSame(500, $userProfilePhotos->photos[0][1]->height);
        $this->assertSame(600, $userProfilePhotos->photos[0][1]->fileSize);
    }
}
