<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\UpdatingMessage;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\EditMessageMedia;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\InputMediaPhoto;
use Vjik\TelegramBot\Api\Type\Message;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class EditMessageMediaTest extends TestCase
{
    public function testBase(): void
    {
        $media = new InputMediaPhoto('https://example.com/photo.jpg');
        $method = new EditMessageMedia(
            $media,
        );

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editMessageMedia', $method->getApiMethod());
        assertSame(
            [
                'media' => $media->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $file = new InputFile((new StreamFactory())->createStream());
        $media = new InputMediaPhoto($file);
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('hello')]]);
        $method = new EditMessageMedia(
            $media,
            'bcid1',
            23,
            34,
            'imid',
            $replyMarkup,
        );

        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 23,
                'message_id' => 34,
                'inline_message_id' => 'imid',
                'media' => [
                    'type' => 'photo',
                    'media' => 'attach://file0',
                ],
                'reply_markup' => $replyMarkup->toRequestArray(),
                'file0' => $file,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditMessageMedia(
            new InputMediaPhoto('https://example.com/photo.jpg'),
        );

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);
        assertTrue($preparedResult);

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->call($method);
        assertInstanceOf(Message::class, $preparedResult);
        assertSame(7, $preparedResult->messageId);
    }
}
