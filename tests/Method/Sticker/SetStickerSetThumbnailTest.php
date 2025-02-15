<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\SetStickerSetThumbnail;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\InputFile;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetStickerSetThumbnailTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetStickerSetThumbnail('animals_by_my_bot', 123, 'static');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setStickerSetThumbnail', $method->getApiMethod());
        assertSame(
            [
                'name' => 'animals_by_my_bot',
                'user_id' => 123,
                'format' => 'static',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $file = new InputFile((new StreamFactory())->createStream());
        $method = new SetStickerSetThumbnail('animals_by_my_bot', 123, 'static', $file);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setStickerSetThumbnail', $method->getApiMethod());
        assertSame(
            [
                'name' => 'animals_by_my_bot',
                'user_id' => 123,
                'thumbnail' => $file,
                'format' => 'static',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetStickerSetThumbnail('animals_by_my_bot', 123, 'static');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
