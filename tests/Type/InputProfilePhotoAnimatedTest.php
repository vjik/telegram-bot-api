<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\FileCollector;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\InputProfilePhoto;
use Vjik\TelegramBot\Api\Type\InputProfilePhotoAnimated;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class InputProfilePhotoAnimatedTest extends TestCase
{
    public function testBase(): void
    {
        $animation = new InputFile((new StreamFactory())->createStream());
        $type = new InputProfilePhotoAnimated($animation);

        assertInstanceOf(InputProfilePhoto::class, $type);
        assertSame('animated', $type->getType());
        assertSame($animation, $type->animation);

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'animated',
                'animation' => 'attach://file0',
            ],
            $type->toRequestArray($fileCollector),
        );
        assertSame(
            [
                'file0' => $animation,
            ],
            $fileCollector->get(),
        );
    }

    public function testFull(): void
    {
        $animation = new InputFile((new StreamFactory())->createStream());
        $type = new InputProfilePhotoAnimated($animation, 2.5);

        assertInstanceOf(InputProfilePhoto::class, $type);
        assertSame('animated', $type->getType());
        assertSame($animation, $type->animation);

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'animated',
                'animation' => 'attach://file0',
                'main_frame_timestamp' => 2.5,
            ],
            $type->toRequestArray($fileCollector),
        );
        assertSame(
            [
                'file0' => $animation,
            ],
            $fileCollector->get(),
        );
    }
}
