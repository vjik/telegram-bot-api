<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\StoryAreaTypeLink;

use function PHPUnit\Framework\assertSame;

final class StoryAreaTypeLinkTest extends TestCase
{
    public function testBase(): void
    {
        $link = new StoryAreaTypeLink(
            url: 'https://example.com',
        );

        assertSame('https://example.com', $link->url);
        assertSame('link', $link->getType());

        assertSame(
            [
                'type' => 'link',
                'url' => 'https://example.com',
            ],
            $link->toRequestArray(),
        );
    }
}
