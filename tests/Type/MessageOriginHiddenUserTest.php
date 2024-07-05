<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\MessageOriginHiddenUser;

final class MessageOriginHiddenUserTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $origin = new MessageOriginHiddenUser($date, 'Mike');

        $this->assertSame('hidden_user', $origin->getType());
        $this->assertSame($date, $origin->getDate());
        $this->assertSame($date, $origin->date);
        $this->assertSame('Mike', $origin->senderUserName);
    }

    public function testFromTelegramResult(): void
    {
        $origin = (new ObjectFactory())->create([
            'type' => 'hidden_user',
            'date' => 12412512,
            'sender_user_name' => 'Mike',
        ], null, MessageOriginHiddenUser::class);

        $this->assertSame('hidden_user', $origin->getType());
        $this->assertSame(12412512, $origin->getDate()->getTimestamp());
        $this->assertSame(12412512, $origin->date->getTimestamp());
        $this->assertSame('Mike', $origin->senderUserName);
    }
}
