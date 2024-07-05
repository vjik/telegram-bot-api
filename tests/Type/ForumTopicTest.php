<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ForumTopic;

final class ForumTopicTest extends TestCase
{
    public function testBase(): void
    {
        $type = new ForumTopic(1, 'test', 0x00FF00);

        $this->assertSame(1, $type->messageThreadId);
        $this->assertSame('test', $type->name);
        $this->assertSame(0x00FF00, $type->iconColor);
        $this->assertNull($type->iconCustomEmojiId);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'message_thread_id' => 1,
            'name' => 'test',
            'icon_color' => 0x00FF00,
            'icon_custom_emoji_id' => '2351346235143',
        ], null, ForumTopic::class);

        $this->assertSame(1, $type->messageThreadId);
        $this->assertSame('test', $type->name);
        $this->assertSame(0x00FF00, $type->iconColor);
        $this->assertSame('2351346235143', $type->iconCustomEmojiId);
    }
}
