<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\SharedUser;
use Vjik\TelegramBot\Api\Type\UsersShared;

final class UsersSharedTest extends TestCase
{
    public function testBase(): void
    {
        $sharedUser = new SharedUser(12);
        $usersShared = new UsersShared(99, [$sharedUser]);

        $this->assertSame(99, $usersShared->requestId);
        $this->assertSame([$sharedUser], $usersShared->users);
    }

    public function testFromTelegramResult(): void
    {
        $usersShared = UsersShared::fromTelegramResult([
            'request_id' => 99,
            'users' => [
                ['user_id' => 12],
            ],
        ]);

        $this->assertSame(99, $usersShared->requestId);

        $this->assertCount(1, $usersShared->users);
        $this->assertSame(12, $usersShared->users[0]->userId);
    }
}
