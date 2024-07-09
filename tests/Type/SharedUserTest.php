<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\SharedUser;

final class SharedUserTest extends TestCase
{
    public function testBase(): void
    {
        $sharedUser = new SharedUser(23);

        $this->assertSame(23, $sharedUser->userId);
        $this->assertNull($sharedUser->firstName);
        $this->assertNull($sharedUser->lastName);
        $this->assertNull($sharedUser->username);
        $this->assertNull($sharedUser->photo);
    }

    public function testFromTelegramResult(): void
    {
        $sharedUser = (new ObjectFactory())->create([
            'user_id' => 23,
            'first_name' => 'John',
            'last_name' => 'Doe',
            'username' => 'bat',
            'photo' => [
                [
                    'file_id' => 'file_id-124',
                    'file_unique_id' => 'file_unique_id',
                    'width' => 23,
                    'height' => 42,
                ],
            ],
        ], null, SharedUser::class);

        $this->assertSame(23, $sharedUser->userId);
        $this->assertSame('John', $sharedUser->firstName);
        $this->assertSame('Doe', $sharedUser->lastName);
        $this->assertSame('bat', $sharedUser->username);

        $this->assertCount(1, $sharedUser->photo);
        $this->assertSame('file_id-124', $sharedUser->photo[0]->fileId);
    }
}
