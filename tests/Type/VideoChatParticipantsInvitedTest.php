<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\User;
use Vjik\TelegramBot\Api\Type\VideoChatParticipantsInvited;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertFalse;
use function PHPUnit\Framework\assertSame;

final class VideoChatParticipantsInvitedTest extends TestCase
{
    public function testBase(): void
    {
        $user = new User(1, false, 'Sergei');
        $videoChatParticipantsInvited = new VideoChatParticipantsInvited([$user]);

        assertSame([$user], $videoChatParticipantsInvited->users);
    }

    public function testFromTelegramResult(): void
    {
        $videoChatParticipantsInvited = (new ObjectFactory())->create([
            'users' => [
                ['id' => 1, 'is_bot' => false, 'first_name' => 'Sergei'],
            ],
        ], null, VideoChatParticipantsInvited::class);

        assertCount(1, $videoChatParticipantsInvited->users);
        assertSame(1, $videoChatParticipantsInvited->users[0]->id);
        assertFalse($videoChatParticipantsInvited->users[0]->isBot);
        assertSame('Sergei', $videoChatParticipantsInvited->users[0]->firstName);
    }
}
