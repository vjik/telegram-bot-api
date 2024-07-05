<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\BackgroundTypeWallpaper;
use Vjik\TelegramBot\Api\Type\Document;

final class BackgroundTypeWallpaperTest extends TestCase
{
    public function testBase(): void
    {
        $document = new Document('f123', 'full123');
        $type = new BackgroundTypeWallpaper($document, 7);

        $this->assertSame('wallpaper', $type->getType());
        $this->assertSame($document, $type->document);
        $this->assertSame(7, $type->darkThemeDimming);
        $this->assertNull($type->isBlurred);
        $this->assertNull($type->isMoving);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'type' => 'wallpaper',
            'document' => [
                'file_id' => 'f123',
                'file_unique_id' => 'full123',
            ],
            'dark_theme_dimming' => 7,
            'is_blurred' => true,
            'is_moving' => true,
        ], null, BackgroundTypeWallpaper::class);

        $this->assertSame('wallpaper', $type->getType());

        $this->assertInstanceOf(Document::class, $type->document);
        $this->assertSame('f123', $type->document->fileId);
        $this->assertSame('full123', $type->document->fileUniqueId);

        $this->assertSame(7, $type->darkThemeDimming);
        $this->assertTrue($type->isBlurred);
        $this->assertTrue($type->isMoving);
    }
}
