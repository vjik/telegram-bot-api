<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Chat;
use Vjik\TelegramBot\Api\Type\Story;

use function PHPUnit\Framework\assertSame;

final class StoryTest extends TestCase
{
    public function testBase(): void
    {
        $chat = new Chat(1, 'private');
        $story = new Story($chat, 25);

        assertSame($chat, $story->chat);
        assertSame(25, $story->id);
    }

    public function testFromTelegramResult(): void
    {
        $story = (new ObjectFactory())->create([
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
            'id' => 25,
        ], null, Story::class);

        assertSame(1, $story->chat->id);
        assertSame(25, $story->id);
    }
}
