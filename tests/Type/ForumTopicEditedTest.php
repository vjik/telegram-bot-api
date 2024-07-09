<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ForumTopicEdited;

final class ForumTopicEditedTest extends TestCase
{
    public function testBase(): void
    {
        $forumTopicEdited = new ForumTopicEdited();

        $this->assertNull($forumTopicEdited->name);
        $this->assertNull($forumTopicEdited->iconCustomEmojiId);
    }

    public function testFromTelegramResult(): void
    {
        $forumTopicEdited = (new ObjectFactory())->create([
            'name' => 'test',
            'icon_custom_emoji_id' => 'x1',
        ], null, ForumTopicEdited::class);

        $this->assertSame('test', $forumTopicEdited->name);
        $this->assertSame('x1', $forumTopicEdited->iconCustomEmojiId);
    }
}
