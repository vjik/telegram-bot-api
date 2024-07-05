<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\MessageReactionUpdated;
use Vjik\TelegramBot\Api\Type\ReactionTypeCustomEmoji;

final class MessageReactionUpdatedTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $date = new DateTimeImmutable();
        $oldReaction = new ReactionTypeCustomEmoji('=)');
        $newReaction = new ReactionTypeCustomEmoji(';)');
        $messageReactionUpdated = new MessageReactionUpdated($chat, 99, $date, [$oldReaction], [$newReaction]);

        $this->assertSame($chat, $messageReactionUpdated->chat);
        $this->assertSame(99, $messageReactionUpdated->messageId);
        $this->assertSame($date, $messageReactionUpdated->date);
        $this->assertSame([$oldReaction], $messageReactionUpdated->oldReaction);
        $this->assertSame([$newReaction], $messageReactionUpdated->newReaction);
    }

    public function testFromTelegramResult(): void
    {
        $messageReactionUpdated = (new ObjectFactory())->create([
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'message_id' => 99,
            'user' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'John',
            ],
            'actor_chat' => [
                'id' => 2,
                'type' => 'private',
            ],
            'date' => 1623150080,
            'old_reaction' => [
                [
                    'type' => 'emoji',
                    'emoji' => '=)',
                ],
            ],
            'new_reaction' => [
                [
                    'type' => 'emoji',
                    'emoji' => ';)',
                ],
            ],
        ], null, MessageReactionUpdated::class);

        $this->assertSame(1, $messageReactionUpdated->chat->id);
        $this->assertSame(99, $messageReactionUpdated->messageId);
        $this->assertSame(1623150080, $messageReactionUpdated->date->getTimestamp());
        $this->assertSame('John', $messageReactionUpdated->user?->firstName);
        $this->assertSame(2, $messageReactionUpdated->actorChat?->id);

        $this->assertCount(1, $messageReactionUpdated->oldReaction);
        $this->assertSame('=)', $messageReactionUpdated->oldReaction[0]->emoji);

        $this->assertCount(1, $messageReactionUpdated->newReaction);
        $this->assertSame(';)', $messageReactionUpdated->newReaction[0]->emoji);
    }
}
