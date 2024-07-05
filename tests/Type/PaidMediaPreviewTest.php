<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\PaidMediaPreview;

final class PaidMediaPreviewTest extends TestCase
{
    public function testBase(): void
    {
        $type = new PaidMediaPreview();

        $this->assertSame('preview', $type->getType());
        $this->assertNull($type->width);
        $this->assertNull($type->height);
        $this->assertNull($type->duration);
    }

    public function testFull(): void
    {
        $type = new PaidMediaPreview(100, 200, 512);

        $this->assertSame('preview', $type->getType());
        $this->assertSame(100, $type->width);
        $this->assertSame(200, $type->height);
        $this->assertSame(512, $type->duration);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'type' => 'preview',
            'width' => 100,
            'height' => 200,
            'duration' => 512,
        ], null, PaidMediaPreview::class);

        $this->assertSame('preview', $type->getType());
        $this->assertSame(100, $type->width);
        $this->assertSame(200, $type->height);
        $this->assertSame(512, $type->duration);
    }
}
