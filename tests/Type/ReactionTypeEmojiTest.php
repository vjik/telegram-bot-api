<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ReactionTypeEmoji;

final class ReactionTypeEmojiTest extends TestCase
{
    public function testBase(): void
    {
        $reaction = new ReactionTypeEmoji('👍');

        $this->assertSame('emoji', $reaction->getType());
        $this->assertSame('👍', $reaction->emoji);
        $this->assertSame(
            [
                'type' => 'emoji',
                'emoji' => '👍',
            ],
            $reaction->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $reaction = (new ObjectFactory())->create([
            'type' => 'emoji',
            'emoji' => '👍',
        ], null, ReactionTypeEmoji::class);

        $this->assertSame('emoji', $reaction->getType());
        $this->assertSame('👍', $reaction->emoji);
    }
}
