<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\File;

use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class FileTest extends TestCase
{
    public function testFile(): void
    {
        $file = new File(
            'x1',
            'fullX1',
        );

        assertSame('x1', $file->fileId);
        assertSame('fullX1', $file->fileUniqueId);
        assertNull($file->fileSize);
        assertNull($file->filePath);
    }

    public function testFromTelegramResult(): void
    {
        $file = (new ObjectFactory())->create([
            'file_id' => 'x1',
            'file_unique_id' => 'fullX1',
            'file_size' => 123,
            'file_path' => 'path/to/file',
        ], null, File::class);

        assertSame('x1', $file->fileId);
        assertSame('fullX1', $file->fileUniqueId);
        assertSame(123, $file->fileSize);
        assertSame('path/to/file', $file->filePath);
    }
}
