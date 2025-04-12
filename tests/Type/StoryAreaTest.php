<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\StoryArea;
use Vjik\TelegramBot\Api\Type\StoryAreaPosition;
use Vjik\TelegramBot\Api\Type\StoryAreaTypeUniqueGift;

use function PHPUnit\Framework\assertSame;

final class StoryAreaTest extends TestCase
{
    public function testToRequestArray(): void
    {
        $position = new StoryAreaPosition(1, 2, 3, 4, 5, 6);
        $type = new StoryAreaTypeUniqueGift('Golden Trophy');
        $storyArea = new StoryArea($position, $type);

        assertSame(
            [
                'position' => $position->toRequestArray(),
                'type' => $type->toRequestArray(),
            ],
            $storyArea->toRequestArray()
        );
    }
}
