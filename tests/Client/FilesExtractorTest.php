<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Client;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Client\FilesExtractor;
use Vjik\TelegramBot\Api\Type\InputFile;

final class FilesExtractorTest extends TestCase
{
    public static function dataBase(): iterable
    {
        yield 'without-files' => [
            [
                'key' => 42,
                'array' => [
                    'test' => 'hello',
                ],
            ],
            [
                'key' => 42,
                'array' => [
                    'test' => 'hello',
                ],
            ],
            []
        ];

        $file = self::createInputFile('test');
        yield 'with-file' => [
            [
                'key' => 42,
                'test' => $file,
            ],
            ['key' => 42],
            ['test' => $file]
        ];

        $file1 = self::createInputFile('test1');
        $file2 = self::createInputFile('test2');
        yield 'array-of-files' => [
            [
                'key' => 42,
                'photos' => [$file1, $file2],
            ],
            ['key' => 42],
            ['photos' => [$file1, $file2]]
        ];

        $file1 = self::createInputFile('test1');
        $file2 = self::createInputFile('test2');
        yield 'mixed-array' => [
            [
                'key' => 42,
                'photos' => [
                    'photo' => $file1,
                    'title' => '34',
                    'thumbnail' => $file2,
                ],
            ],
            [
                'key' => 42,
                'photos' => [
                    'title' => '34',
                ],
            ],
            [
                'photos' => [
                    'photo' => $file1,
                    'thumbnail' => $file2,
                ],
            ],
        ];
    }

    #[DataProvider('dataBase')]
    public function testBase(array $data, array $expectedData, array $expectedFiles): void
    {
        $extractor = new FilesExtractor();

        $files = $extractor->extract($data);

        $this->assertSame($expectedData, $data);
        $this->assertSame($expectedFiles, $files);
    }

    private static function createInputFile(string $content): InputFile
    {
        return new InputFile(
            (new StreamFactory())->createStream($content),
        );
    }
}
