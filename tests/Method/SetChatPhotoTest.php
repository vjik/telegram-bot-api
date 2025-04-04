<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetChatPhoto;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\InputFile;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetChatPhotoTest extends TestCase
{
    public function testBase(): void
    {
        $photo = new InputFile('/path/to/photo.jpg');
        $method = new SetChatPhoto(1, $photo);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setChatPhoto', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'photo' => $photo,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $photo = new InputFile('/path/to/photo.jpg');
        $method = new SetChatPhoto(1, $photo);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
