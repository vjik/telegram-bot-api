<?php

declare(strict_types=1);

namespace Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BusinessConnection;
use Vjik\TelegramBot\Api\Type\User;

final class BusinessConnectionTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(123, false, 'Sergei');
        $date = new DateTimeImmutable();
        $businessConnection = new BusinessConnection(
            'id1',
            $user,
            23,
            $date,
            true,
            false,
        );

        $this->assertSame('id1', $businessConnection->id);
        $this->assertSame($user, $businessConnection->user);
        $this->assertSame(23, $businessConnection->userChatId);
        $this->assertSame($date, $businessConnection->date);
        $this->assertTrue($businessConnection->canReply);
        $this->assertFalse($businessConnection->isEnabled);
    }

    public function testFromTelegramResult(): void
    {
        $businessConnection = BusinessConnection::fromTelegramResult([
            'id' => 'id1',
            'user' => [
                'id' => 123,
                'is_bot' => false,
                'first_name' => 'Sergei',
            ],
            'user_chat_id' => 23,
            'date' => 1717517779,
            'can_reply' => true,
            'is_enabled' => false,
        ]);

        $this->assertSame('id1', $businessConnection->id);
        $this->assertSame(123, $businessConnection->user->id);
        $this->assertSame(23, $businessConnection->userChatId);
        $this->assertSame(1717517779, $businessConnection->date->getTimestamp());
        $this->assertTrue($businessConnection->canReply);
        $this->assertFalse($businessConnection->isEnabled);
    }
}
