<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Sticker;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Sticker\SendSticker;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

final class SendStickerTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendSticker(12, 'https://example.com/sticker.webp');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('sendSticker', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 12,
                'sticker' => 'https://example.com/sticker.webp',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $sticker = new InputFile((new StreamFactory())->createStream());
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendSticker(
            12,
            $sticker,
            'bcid1',
            99,
            '👍',
            true,
            false,
            'meid1',
            $replyParameters,
            $replyMarkup,
            true,
        );

        $this->assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'message_thread_id' => 99,
                'sticker' => $sticker,
                'emoji' => '👍',
                'disable_notification' => true,
                'protect_content' => false,
                'allow_paid_broadcast' => true,
                'message_effect_id' => 'meid1',
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendSticker(12, 'https://example.com/sticker.webp');

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->call($method);

        $this->assertSame(7, $preparedResult->messageId);
    }
}
