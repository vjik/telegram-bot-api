<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\VideoNote;

final class VideoNoteTest extends TestCase
{
    public function testBase(): void
    {
        $videoNote = new VideoNote('f1', 'fu1', 200, 32);

        $this->assertSame('f1', $videoNote->fileId);
        $this->assertSame('fu1', $videoNote->fileUniqueId);
        $this->assertSame(200, $videoNote->length);
        $this->assertSame(32, $videoNote->duration);
        $this->assertNull($videoNote->thumbnail);
        $this->assertNull($videoNote->fileSize);
    }

    public function testFromTelegramResult(): void
    {
        $videoNote = VideoNote::fromTelegramResult([
            'file_id' => 'f1',
            'file_unique_id' => 'fu1',
            'length' => 200,
            'duration' => 32,
            'thumbnail' => [
                'file_id' => 'f2',
                'file_unique_id' => 'fu2',
                'width' => 104,
                'height' => 205,
            ],
            'file_size' => 100,
        ]);

        $this->assertSame('f1', $videoNote->fileId);
        $this->assertSame('fu1', $videoNote->fileUniqueId);
        $this->assertSame(200, $videoNote->length);
        $this->assertSame(32, $videoNote->duration);
        $this->assertSame('f2', $videoNote->thumbnail?->fileId);
        $this->assertSame(100, $videoNote->fileSize);
    }
}
