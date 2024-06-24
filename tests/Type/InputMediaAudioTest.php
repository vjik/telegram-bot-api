<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Request\RequestFileCollector;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\InputMediaAudio;
use Vjik\TelegramBot\Api\Type\MessageEntity;

final class InputMediaAudioTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputMediaAudio('https://example.com/start.mp3');

        $this->assertSame('audio', $inputMedia->getType());
        $this->assertSame(
            [
                'type' => 'audio',
                'media' => 'https://example.com/start.mp3',
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new RequestFileCollector();
        $this->assertSame(
            [
                'type' => 'audio',
                'media' => 'https://example.com/start.mp3',
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
        $inputMedia = new InputMediaAudio(
            $media,
            $thumbnail,
            'Hello',
            'HTML',
            [$entity],
            15,
            'The performer',
            'The title',
        );

        $this->assertSame('audio', $inputMedia->getType());
        $this->assertSame(
            [
                'type' => 'audio',
                'media' => $media,
                'thumbnail' => $thumbnail,
                'caption' => 'Hello',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'duration' => 15,
                'performer' => 'The performer',
                'title' => 'The title',
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new RequestFileCollector();
        $this->assertSame(
            [
                'type' => 'audio',
                'media' => 'attach://file0',
                'thumbnail' => 'attach://file1',
                'caption' => 'Hello',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'duration' => 15,
                'performer' => 'The performer',
                'title' => 'The title',
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
