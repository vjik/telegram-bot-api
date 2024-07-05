<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\User;
use Vjik\TelegramBot\Api\Type\VideoChatParticipantsInvited;

final class VideoChatParticipantsInvitedTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'Sergei');
        $videoChatParticipantsInvited = new VideoChatParticipantsInvited([$user]);

        $this->assertSame([$user], $videoChatParticipantsInvited->users);
    }

    public function testFromTelegramResult(): void
    {
        $videoChatParticipantsInvited = (new ObjectFactory())->create([
            'users' => [
                ['id' => 1, 'is_bot' => false, 'first_name' => 'Sergei'],
            ],
        ], null, VideoChatParticipantsInvited::class);

        $this->assertCount(1, $videoChatParticipantsInvited->users);
        $this->assertSame(1, $videoChatParticipantsInvited->users[0]->id);
        $this->assertFalse($videoChatParticipantsInvited->users[0]->isBot);
        $this->assertSame('Sergei', $videoChatParticipantsInvited->users[0]->firstName);
    }
}
