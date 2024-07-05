<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ForumTopicCreated;

final class ForumTopicCreatedTest extends TestCase
{
    public function testBase(): void
    {
        $forumTopicCreated = new ForumTopicCreated('test', 0x123456);

        $this->assertSame('test', $forumTopicCreated->name);
        $this->assertSame(0x123456, $forumTopicCreated->iconColor);
        $this->assertNull($forumTopicCreated->iconCustomEmojiId);
    }

    public function testFromTelegramResult(): void
    {
        $forumTopicCreated = (new ObjectFactory())->create([
            'name' => 'test',
            'icon_color' => 0x123456,
            'icon_custom_emoji_id' => 'x1'
        ], null, ForumTopicCreated::class);

        $this->assertSame('test', $forumTopicCreated->name);
        $this->assertSame(0x123456, $forumTopicCreated->iconColor);
        $this->assertSame('x1', $forumTopicCreated->iconCustomEmojiId);
    }
}
