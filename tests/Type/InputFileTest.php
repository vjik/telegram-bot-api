<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Vjik\TelegramBot\Api\Type\InputFile;

final class InputFileTest extends TestCase
{
    public function testBase(): void
    {
        $stream = (new StreamFactory())->createStream('test');
        $file = new InputFile($stream);

        $this->assertSame($stream, $file->resource);
        $this->assertNull($file->filename);
    }

    public function testFilled(): void
    {
        $stream = (new StreamFactory())->createStream('test');
        $file = new InputFile($stream, 'file.txt');

        $this->assertSame($stream, $file->resource);
        $this->assertSame('file.txt', $file->filename);
    }

    public function testFromLocalFile(): void
    {
        $file = InputFile::fromLocalFile(__FILE__);

        $this->assertIsResource($file->resource);
        $this->assertNull($file->filename);
    }

    public function testFromLocalFileWithName(): void
    {
        $file = InputFile::fromLocalFile(__FILE__, 'test.php');

        $this->assertIsResource($file->resource);
        $this->assertSame('test.php', $file->filename);
    }

    public function testFromLocalNotExistsFile(): void
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Unable to open file "not-exists".');
        InputFile::fromLocalFile('not-exists');
    }
}
