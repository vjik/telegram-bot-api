<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BackgroundFillSolid;
use Vjik\TelegramBot\Api\Type\BackgroundTypePattern;
use Vjik\TelegramBot\Api\Type\Document;

final class BackgroundTypePatternTest extends TestCase
{
    public function testBase(): void
    {
        $document = new Document('f123', 'full123');
        $fill = new BackgroundFillSolid(0x000000);
        $type = new BackgroundTypePattern($document, $fill, 5);

        $this->assertSame('pattern', $type->getType());
        $this->assertSame($document, $type->document);
        $this->assertSame($fill, $type->fill);
        $this->assertSame(5, $type->intensity);
        $this->assertNull($type->isInverted);
        $this->assertNull($type->isMoving);
    }

    public function testFromTelegramResult(): void
    {
        $type = BackgroundTypePattern::fromTelegramResult([
            'type' => 'pattern',
            'document' => [
                'file_id' => 'f123',
                'file_unique_id' => 'full123',
            ],
            'fill' => [
                'type' => 'solid',
                'color' => 0x000000
            ],
            'intensity' => 5,
            'is_inverted' => true,
            'is_moving' => true,
        ]);

        $this->assertSame('pattern', $type->getType());

        $this->assertInstanceOf(Document::class, $type->document);
        $this->assertSame('f123', $type->document->fileId);
        $this->assertSame('full123', $type->document->fileUniqueId);

        $this->assertInstanceOf(BackgroundFillSolid::class, $type->fill);
        $this->assertSame(0x000000, $type->fill->color);

        $this->assertSame(5, $type->intensity);
        $this->assertTrue($type->isInverted);
        $this->assertTrue($type->isMoving);
    }
}
