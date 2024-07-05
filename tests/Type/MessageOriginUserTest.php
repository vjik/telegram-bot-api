<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\MessageOriginUser;
use Vjik\TelegramBot\Api\Type\User;

final class MessageOriginUserTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $user = new User(1, false, 'Mike');
        $origin = new MessageOriginUser($date, $user);

        $this->assertSame('user', $origin->getType());
        $this->assertSame($date, $origin->getDate());
        $this->assertSame($date, $origin->date);
        $this->assertSame($user, $origin->senderUser);
    }

    public function testFromTelegramResult(): void
    {
        $origin = (new ObjectFactory())->create([
            'type' => 'user',
            'date' => 12412512,
            'sender_user' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Mike',
            ],
        ], null, MessageOriginUser::class);

        $this->assertSame('user', $origin->getType());
        $this->assertSame(12412512, $origin->getDate()->getTimestamp());
        $this->assertSame(12412512, $origin->date->getTimestamp());
        $this->assertSame(1, $origin->senderUser->id);
    }
}
