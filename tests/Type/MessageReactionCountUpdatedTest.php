<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\MessageReactionCountUpdated;
use Vjik\TelegramBot\Api\Type\ReactionCount;
use Vjik\TelegramBot\Api\Type\ReactionTypeCustomEmoji;

final class MessageReactionCountUpdatedTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $reactionCount = new ReactionCount(new ReactionTypeCustomEmoji('=)'), 1);
        $date = new DateTimeImmutable();
        $messageReactionCountUpdated = new MessageReactionCountUpdated($chat, 99, $date, [$reactionCount]);

        $this->assertSame($chat, $messageReactionCountUpdated->chat);
        $this->assertSame(99, $messageReactionCountUpdated->messageId);
        $this->assertSame($date, $messageReactionCountUpdated->date);
        $this->assertSame([$reactionCount], $messageReactionCountUpdated->reactions);
    }

    public function testFromTelegramResult(): void
    {
        $messageReactionCountUpdated = MessageReactionCountUpdated::fromTelegramResult([
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'message_id' => 99,
            'date' => 1623150080,
            'reactions' => [
                [
                    'type' => [
                        'type' => 'emoji',
                        'emoji' => '🤯',
                    ],
                    'total_count' => 2,
                ],
            ],
        ]);

        $this->assertSame(1, $messageReactionCountUpdated->chat->id);
        $this->assertSame(99, $messageReactionCountUpdated->messageId);
        $this->assertSame(1623150080, $messageReactionCountUpdated->date->getTimestamp());

        $this->assertCount(1, $messageReactionCountUpdated->reactions);
        $this->assertSame('🤯', $messageReactionCountUpdated->reactions[0]->type->emoji);
    }
}
