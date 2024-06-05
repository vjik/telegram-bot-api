<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\LinkPreviewOptions;

final class LinkPreviewOptionsTest extends TestCase
{
    public function testBase(): void
    {
        $options = new LinkPreviewOptions();

        $this->assertNull($options->isDisabled);
        $this->assertNull($options->url);
        $this->assertNull($options->preferSmallMedia);
        $this->assertNull($options->preferLargeMedia);
        $this->assertNull($options->showAboveText);

        $this->assertSame([], $options->toRequestArray());
    }

    public function testFilled(): void
    {
        $options = new LinkPreviewOptions(true, 'https://example.com/', true, false, true);

        $this->assertTrue($options->isDisabled);
        $this->assertSame('https://example.com/', $options->url);
        $this->assertTrue($options->preferSmallMedia);
        $this->assertFalse($options->preferLargeMedia);
        $this->assertTrue($options->showAboveText);

        $this->assertSame(
            [
                'is_disabled' => true,
                'url' => 'https://example.com/',
                'prefer_small_media' => true,
                'prefer_large_media' => false,
                'show_above_text' => true,
            ],
            $options->toRequestArray(),
        );
    }

    public function testFromTelegramResult(): void
    {
        $options = LinkPreviewOptions::fromTelegramResult([
            'is_disabled' => true,
            'url' => 'https://example.com/',
            'prefer_small_media' => true,
            'prefer_large_media' => false,
            'show_above_text' => true,
        ]);

        $this->assertTrue($options->isDisabled);
        $this->assertSame('https://example.com/', $options->url);
        $this->assertTrue($options->preferSmallMedia);
        $this->assertFalse($options->preferLargeMedia);
        $this->assertTrue($options->showAboveText);
    }
}
