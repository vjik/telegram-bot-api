<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Request\RequestFileCollector;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\InputMediaDocument;
use Vjik\TelegramBot\Api\Type\MessageEntity;

final class InputMediaDocumentTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputMediaDocument('https://example.com/start.doc');

        $this->assertSame('document', $inputMedia->getType());
        $this->assertSame(
            [
                'type' => 'document',
                'media' => 'https://example.com/start.doc',
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new RequestFileCollector();
        $this->assertSame(
            [
                'type' => 'document',
                'media' => 'https://example.com/start.doc',
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        $this->assertEmpty($fileCollector->get());
    }

    public function testFull(): void
    {
        $media = new InputFile((new StreamFactory())->createStream());
        $thumbnail = new InputFile((new StreamFactory())->createStream());
        $entity = new MessageEntity('bold', 0, 4);
        $inputMedia = new InputMediaDocument(
            $media,
            $thumbnail,
            'Hello',
            'HTML',
            [$entity],
            false,
        );

        $this->assertSame('document', $inputMedia->getType());
        $this->assertSame(
            [
                'type' => 'document',
                'media' => $media,
                'thumbnail' => $thumbnail,
                'caption' => 'Hello',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'disable_content_type_detection' => false,
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new RequestFileCollector();
        $this->assertSame(
            [
                'type' => 'document',
                'media' => 'attach://file0',
                'thumbnail' => 'attach://file1',
                'caption' => 'Hello',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'disable_content_type_detection' => false,
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        $this->assertSame(
            [
                'file0' => $media,
                'file1' => $thumbnail,
            ],
            $fileCollector->get(),
        );
    }
}
