<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ReactionTypeEmoji;

use function PHPUnit\Framework\assertSame;

final class ReactionTypeEmojiTest extends TestCase
{
    public function testBase(): void
    {
        $reaction = new ReactionTypeEmoji('👍');

        assertSame('emoji', $reaction->getType());
        assertSame('👍', $reaction->emoji);
        assertSame(
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

        assertSame('emoji', $reaction->getType());
        assertSame('👍', $reaction->emoji);
    }
}
