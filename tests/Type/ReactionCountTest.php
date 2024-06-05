<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ReactionCount;
use Vjik\TelegramBot\Api\Type\ReactionTypeEmoji;

final class ReactionCountTest extends TestCase
{
    public function testBase(): void
    {
        $reactionType = new ReactionTypeEmoji('👍');
        $count = new ReactionCount($reactionType, 23);

        $this->assertSame($reactionType, $count->type);
        $this->assertSame(23, $count->totalCount);
    }

    public function testFromTelegramResult(): void
    {
        $count = ReactionCount::fromTelegramResult([
            'type' => [
                'type' => 'emoji',
                'emoji' => '👍',
            ],
            'total_count' => 23,
        ]);

        $this->assertSame('👍', $count->type->emoji);
        $this->assertSame(23, $count->totalCount);
    }
}
