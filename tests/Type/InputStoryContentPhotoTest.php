<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\FileCollector;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\InputStoryContent;
use Vjik\TelegramBot\Api\Type\InputStoryContentPhoto;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class InputStoryContentPhotoTest extends TestCase
{
    public function testBase(): void
    {
        $photo = new InputFile((new StreamFactory())->createStream());
        $type = new InputStoryContentPhoto($photo);

        assertInstanceOf(InputStoryContent::class, $type);
        assertSame('photo', $type->getType());
        assertSame($photo, $type->photo);

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'photo',
                'photo' => 'attach://file0',
            ],
            $type->toRequestArray($fileCollector),
        );
        assertSame(
            [
                'file0' => $photo,
            ],
            $fileCollector->get(),
        );
    }
}
