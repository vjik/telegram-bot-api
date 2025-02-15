<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\ReactionCount;
use Vjik\TelegramBot\Api\Type\ReactionTypeEmoji;

use function PHPUnit\Framework\assertSame;

final class ReactionCountTest extends TestCase
{
    public function testBase(): void
    {
        $reactionType = new ReactionTypeEmoji('👍');
        $count = new ReactionCount($reactionType, 23);

        assertSame($reactionType, $count->type);
        assertSame(23, $count->totalCount);
    }

    public function testFromTelegramResult(): void
    {
        $count = (new ObjectFactory())->create([
            'type' => [
                'type' => 'emoji',
                'emoji' => '👍',
            ],
            'total_count' => 23,
        ], null, ReactionCount::class);

        assertSame('👍', $count->type->emoji);
        assertSame(23, $count->totalCount);
    }
}
