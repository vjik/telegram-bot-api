<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\FileCollector;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\InputProfilePhoto;
use Vjik\TelegramBot\Api\Type\InputProfilePhotoStatic;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class InputProfilePhotoStaticTest extends TestCase
{
    public function testBase(): void
    {
        $photo = new InputFile((new StreamFactory())->createStream());
        $type = new InputProfilePhotoStatic($photo);

        assertInstanceOf(InputProfilePhoto::class, $type);
        assertSame('static', $type->getType());
        assertSame($photo, $type->photo);

        $fileCollector = new FileCollector();
        assertSame(
            [
                'type' => 'static',
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
