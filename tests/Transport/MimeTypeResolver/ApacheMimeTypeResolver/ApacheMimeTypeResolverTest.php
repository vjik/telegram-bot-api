<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Transport\MimeTypeResolver\ApacheMimeTypeResolver;

use HttpSoft\Message\Stream;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Transport\MimeTypeResolver\ApacheMimeTypeResolver;
use Vjik\TelegramBot\Api\Type\InputFile;

use function PHPUnit\Framework\assertSame;

final class ApacheMimeTypeResolverTest extends TestCase
{
    public static function dataBase(): iterable
    {
        yield [null, new InputFile(new Stream())];
        yield [null, new InputFile(new Stream(), 'test.non-exist-extension')];
        yield ['image/jpeg', new InputFile(new Stream(), 'test.jpg')];
        yield ['text/plain', InputFile::fromLocalFile(__DIR__ . '/test.txt')];
        yield ['text/css', InputFile::fromLocalFile(__DIR__ . '/test.txt', 'test.css')];
    }

    #[DataProvider('dataBase')]
    public function testBase(?string $expected, InputFile $file): void
    {
        $resolver = new ApacheMimeTypeResolver();

        $result = $resolver->resolve($file);

        assertSame($expected, $result);
    }
}
