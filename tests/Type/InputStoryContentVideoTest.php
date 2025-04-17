<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\FileCollector;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\InputStoryContent;
use Vjik\TelegramBot\Api\Type\InputStoryContentVideo;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class InputStoryContentVideoTest extends TestCase
{
    public function testBase(): void
    {
        $video = new InputFile((new StreamFactory())->createStream());
        $type = new InputStoryContentVideo($video);

        assertInstanceOf(InputStoryContent::class, $type);
        assertSame('video', $type->getType());
        assertSame($video, $type->video);

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'video',
                'video' => 'attach://file0',
            ],
            $type->toRequestArray($fileCollector),
        );
        assertSame(
            [
                'file0' => $video,
            ],
            $fileCollector->get(),
        );
    }

    public function testFull(): void
    {
        $video = new InputFile((new StreamFactory())->createStream());
        $type = new InputStoryContentVideo($video, 10.5, 2.5, true);

        assertInstanceOf(InputStoryContent::class, $type);
        assertSame('video', $type->getType());
        assertSame($video, $type->video);
        assertSame(10.5, $type->duration);
        assertSame(2.5, $type->coverFrameTimestamp);
        assertTrue($type->isAnimation);

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'video',
                'video' => 'attach://file0',
                'duration' => 10.5,
                'cover_frame_timestamp' => 2.5,
                'is_animation' => true,
            ],
            $type->toRequestArray($fileCollector),
        );
        assertSame(
            [
                'file0' => $video,
            ],
            $fileCollector->get(),
        );
    }
}
