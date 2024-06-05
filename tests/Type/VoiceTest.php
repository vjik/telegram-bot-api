<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Voice;

final class VoiceTest extends TestCase
{
    public function testBase(): void
    {
        $voice = new Voice('f1', 'fu1', 23);

        $this->assertSame('f1', $voice->fileId);
        $this->assertSame('fu1', $voice->fileUniqueId);
        $this->assertSame(23, $voice->duration);
        $this->assertNull($voice->mimeType);
        $this->assertNull($voice->fileSize);
    }

    public function testFromTelegramResult(): void
    {
        $voice = Voice::fromTelegramResult([
            'file_id' => 'f1',
            'file_unique_id' => 'fu1',
            'duration' => 23,
            'mime_type' => 'audio/mpeg',
            'file_size' => 100,
        ]);

        $this->assertSame('f1', $voice->fileId);
        $this->assertSame('fu1', $voice->fileUniqueId);
        $this->assertSame(23, $voice->duration);
        $this->assertSame('audio/mpeg', $voice->mimeType);
        $this->assertSame(100, $voice->fileSize);
    }
}
