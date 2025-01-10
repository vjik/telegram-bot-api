<?php

declare(strict_types=1);

namespace Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\InputFileCollector;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\InputPaidMediaVideo;

final class InputPaidMediaVideoTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputPaidMediaVideo('https://example.com/start.mp4');

        $this->assertSame('video', $inputMedia->getType());
        $this->assertSame(
            [
                'type' => 'video',
                'media' => 'https://example.com/start.mp4',
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new InputFileCollector();
        $this->assertSame(
            [
                'type' => 'video',
                'media' => 'https://example.com/start.mp4',
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        $this->assertEmpty($fileCollector->get());
    }

    public function testFull(): void
    {
        $media = new InputFile((new StreamFactory())->createStream());
        $thumbnail = new InputFile((new StreamFactory())->createStream());
        $inputMedia = new InputPaidMediaVideo(
            $media,
            $thumbnail,
            240,
            320,
            500,
            true,
        );

        $this->assertSame('video', $inputMedia->getType());
        $this->assertSame(
            [
                'type' => 'video',
                'media' => $media,
                'thumbnail' => $thumbnail,
                'width' => 240,
                'height' => 320,
                'duration' => 500,
                'supports_streaming' => true,
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new InputFileCollector();
        $this->assertSame(
            [
                'type' => 'video',
                'media' => 'attach://file0',
                'thumbnail' => 'attach://file1',
                'width' => 240,
                'height' => 320,
                'duration' => 500,
                'supports_streaming' => true,
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
