<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Document;
use Vjik\TelegramBot\Api\Type\PhotoSize;

final class DocumentTest extends TestCase
{
    public function testBase(): void
    {
        $document = new Document('x1', 'xf1');

        $this->assertSame('x1', $document->fileId);
        $this->assertSame('xf1', $document->fileUniqueId);
        $this->assertNull($document->thumbnail);
        $this->assertNull($document->fileName);
        $this->assertNull($document->mimeType);
        $this->assertNull($document->fileSize);
    }

    public function testFromTelegramResult(): void
    {
        $document = (new ObjectFactory())->create([
            'file_id' => 'x1',
            'file_unique_id' => 'xf1',
            'thumbnail' => [
                'file_id' => 'tf1',
                'file_unique_id' => 'tfu1',
                'width' => 1,
                'height' => 2,
            ],
            'file_name' => 'face.png',
            'mime_type' => 'image/png',
            'file_size' => 123,
        ], null, Document::class);

        $this->assertSame('x1', $document->fileId);
        $this->assertSame('xf1', $document->fileUniqueId);

        $this->assertInstanceOf(PhotoSize::class, $document->thumbnail);
        $this->assertSame('tf1', $document->thumbnail->fileId);
        $this->assertSame('tfu1', $document->thumbnail->fileUniqueId);

        $this->assertSame('face.png', $document->fileName);
        $this->assertSame('image/png', $document->mimeType);
        $this->assertSame(123, $document->fileSize);
    }
}
