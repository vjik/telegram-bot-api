<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\ReactionType;
use Vjik\TelegramBot\Api\Type\ReactionTypeCustomEmoji;
use Vjik\TelegramBot\Api\Type\StoryAreaTypeSuggestedReaction;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class StoryAreaTypeSuggestedReactionTest extends TestCase
{
    public function testBase(): void
    {
        $reactionType = new ReactionTypeCustomEmoji('xxx');
        $type = new StoryAreaTypeSuggestedReaction($reactionType);

        assertSame($reactionType, $type->reactionType);
        assertNull($type->isDark);
        assertNull($type->isFlipped);

        assertSame(
            [
                'type' => 'suggested_reaction',
                'reaction_type' => $reactionType->toRequestArray(),
            ],
            $type->toRequestArray()
        );
    }

    public function testFull(): void
    {
        $reactionType = new ReactionTypeCustomEmoji('xxx');
        $suggestedReaction = new StoryAreaTypeSuggestedReaction(
            $reactionType,
            true,
            false
        );

        assertSame($reactionType, $suggestedReaction->reactionType);
        assertSame(true, $suggestedReaction->isDark);
        assertSame(false, $suggestedReaction->isFlipped);

        assertSame(
            [
                'type' => 'suggested_reaction',
                'reaction_type' => $reactionType->toRequestArray(),
                'is_dark' => true,
                'is_flipped' => false,
            ],
            $suggestedReaction->toRequestArray()
        );
    }
}
