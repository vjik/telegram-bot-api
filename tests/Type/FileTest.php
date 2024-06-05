<?php

declare(strict_types=1);

namespace Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\File;

final class FileTest extends TestCase
{
    public function testFile(): void
    {
        $file = new File(
            'x1',
            'fullX1',
        );

        $this->assertSame('x1', $file->fileId);
        $this->assertSame('fullX1', $file->fileUniqueId);
        $this->assertNull($file->fileSize);
        $this->assertNull($file->filePath);
    }

    public function testFromTelegramResult(): void
    {
        $file = File::fromTelegramResult([
            'file_id' => 'x1',
            'file_unique_id' => 'fullX1',
            'file_size' => 123,
            'file_path' => 'path/to/file',
        ]);

        $this->assertSame('x1', $file->fileId);
        $this->assertSame('fullX1', $file->fileUniqueId);
        $this->assertSame(123, $file->fileSize);
        $this->assertSame('path/to/file', $file->filePath);
    }
}
