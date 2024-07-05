<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\UploadStickerFile;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\InputFile;

final class UploadStickerFileTest extends TestCase
{
    public function testBase(): void
    {
        $file = new InputFile((new StreamFactory())->createStream());
        $method = new UploadStickerFile(1, $file, 'static');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('uploadStickerFile', $method->getApiMethod());
        $this->assertSame(
            [
                'user_id' => 1,
                'sticker' => $file,
                'sticker_format' => 'static',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new UploadStickerFile(1, new InputFile((new StreamFactory())->createStream()), 'static');

        $preparedResult = TestHelper::createSuccessStubApi([
            'file_id' => 'f1',
            'file_unique_id' => 'fullX1',
            'file_size' => 123,
            'file_path' => 'path/to/file',
        ])->send($method);

        $this->assertSame('f1', $preparedResult->fileId);
    }
}
