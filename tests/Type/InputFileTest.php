<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\Attributes\WithoutErrorHandler;
use PHPUnit\Framework\TestCase;
use RuntimeException;
use Throwable;
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

    #[WithoutErrorHandler]
    public function testFromLocalNotExistsFile(): void
    {
        $errorMessage = null;
        set_error_handler(
            static function (int $code, string $message) use (&$errorMessage): bool {
                $errorMessage = $message;
                return true;
            },
        );

        $exception = null;
        try {
            InputFile::fromLocalFile('not-exists');
        } catch (Throwable $exception) {
        }

        restore_error_handler();

        $this->assertSame('fopen(not-exists): Failed to open stream: No such file or directory', $errorMessage);
        $this->assertInstanceOf(RuntimeException::class, $exception);
        $this->assertSame('Unable to open file "not-exists".', $exception->getMessage());
    }
}
