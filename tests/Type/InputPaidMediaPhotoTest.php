<?php

declare(strict_types=1);

namespace Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\RequestFileCollector;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\InputPaidMediaPhoto;

final class InputPaidMediaPhotoTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputPaidMediaPhoto('https://example.com/start.png');

        $this->assertSame('photo', $inputMedia->getType());
        $this->assertSame(
            [
                'type' => 'photo',
                'media' => 'https://example.com/start.png',
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new RequestFileCollector();
        $this->assertSame(
            [
                'type' => 'photo',
                'media' => 'https://example.com/start.png',
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        $this->assertEmpty($fileCollector->get());
    }

    public function testFull(): void
    {
        $media = new InputFile((new StreamFactory())->createStream());
        $inputMedia = new InputPaidMediaPhoto($media);

        $this->assertSame('photo', $inputMedia->getType());
        $this->assertSame(
            [
                'type' => 'photo',
                'media' => $media,
            ],
            $inputMedia->toRequestArray(),
        );

        $fileCollector = new RequestFileCollector();
        $this->assertSame(
            [
                'type' => 'photo',
                'media' => 'attach://file0',
            ],
            $inputMedia->toRequestArray($fileCollector),
        );
        $this->assertSame(
            [
                'file0' => $media,
            ],
            $fileCollector->get(),
        );
    }
}
