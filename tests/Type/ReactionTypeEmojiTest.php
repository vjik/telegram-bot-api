<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ReactionTypeEmoji;

final class ReactionTypeEmojiTest extends TestCase
{
    public function testBase(): void
    {
        $reaction = new ReactionTypeEmoji('👍');

        $this->assertSame('emoji', $reaction->getType());
        $this->assertSame('👍', $reaction->emoji);
    }

    public function testFromTelegramResult(): void
    {
        $reaction = ReactionTypeEmoji::fromTelegramResult([
            'type' => 'emoji',
            'emoji' => '👍',
        ]);

        $this->assertSame('emoji', $reaction->getType());
        $this->assertSame('👍', $reaction->emoji);
    }
}
