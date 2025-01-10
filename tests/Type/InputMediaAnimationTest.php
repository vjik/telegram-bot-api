<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\InputFileCollector;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\InputMediaAnimation;
use Vjik\TelegramBot\Api\Type\MessageEntity;

final class InputMediaAnimationTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputMediaAnimation('https://example.com/anime.gif');

        $this->assertSame('animation', $inputMedia->getType());
        $this->assertSame(
            [
                'type' => 'animation',
                'media' => 'https://example.com/anime.gif',
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new InputFileCollector();
        $this->assertSame(
            [
                'type' => 'animation',
                'media' => 'https://example.com/anime.gif',
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
        $inputMedia = new InputMediaAnimation(
            $media,
            $thumbnail,
            'Hello',
            'HTML',
            [$entity],
            true,
            240,
            320,
            23,
            false,
        );

        $this->assertSame('animation', $inputMedia->getType());
        $this->assertSame(
            [
                'type' => 'animation',
                'media' => $media,
                'thumbnail' => $thumbnail,
                'caption' => 'Hello',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => true,
                'width' => 240,
                'height' => 320,
                'duration' => 23,
                'has_spoiler' => false,
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new InputFileCollector();
        $this->assertSame(
            [
                'type' => 'animation',
                'media' => 'attach://file0',
                'thumbnail' => 'attach://file1',
                'caption' => 'Hello',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => true,
                'width' => 240,
                'height' => 320,
                'duration' => 23,
                'has_spoiler' => false,
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
