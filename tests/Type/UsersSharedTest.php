<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\SharedUser;
use Vjik\TelegramBot\Api\Type\UsersShared;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertSame;

final class UsersSharedTest extends TestCase
{
    public function testBase(): void
    {
        $sharedUser = new SharedUser(12);
        $usersShared = new UsersShared(99, [$sharedUser]);

        assertSame(99, $usersShared->requestId);
        assertSame([$sharedUser], $usersShared->users);
    }

    public function testFromTelegramResult(): void
    {
        $usersShared = (new ObjectFactory())->create([
            'request_id' => 99,
            'users' => [
                ['user_id' => 12],
            ],
        ], null, UsersShared::class);

        assertSame(99, $usersShared->requestId);

        assertCount(1, $usersShared->users);
        assertSame(12, $usersShared->users[0]->userId);
    }
}
