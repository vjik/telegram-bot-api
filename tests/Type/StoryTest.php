<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\Story;

final class StoryTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $story = new Story($chat, 25);

        $this->assertSame($chat, $story->chat);
        $this->assertSame(25, $story->id);
    }

    public function testFromTelegramResult(): void
    {
        $story = Story::fromTelegramResult([
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'id' => 25,
        ]);

        $this->assertSame(1, $story->chat->id);
        $this->assertSame(25, $story->id);
    }
}
