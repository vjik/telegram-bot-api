<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\ReplaceStickerInSet;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\Sticker\InputSticker;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class ReplaceStickerInSetTest extends TestCase
{
    public function testBase(): void
    {
        $file = new InputFile((new StreamFactory())->createStream());
        $inputSticker = new InputSticker($file, 'static', ['😀']);
        $method = new ReplaceStickerInSet(1, 'test', 'oldid', $inputSticker);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('replaceStickerInSet', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 1,
                'name' => 'test',
                'old_sticker' => 'oldid',
                'sticker' => [
                    'sticker' => 'attach://file0',
                    'format' => 'static',
                    'emoji_list' => ['😀'],
                ],
                'file0' => $file,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new ReplaceStickerInSet(
            1,
            'test',
            'oldid',
            new InputSticker('https://example.com/sticker.webp', 'static', ['😀']),
        );

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
