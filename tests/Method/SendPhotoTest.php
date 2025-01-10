<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SendPhoto;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

final class SendPhotoTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendPhoto(12, 'https://example.com/i.png');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('sendPhoto', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 12,
                'photo' => 'https://example.com/i.png',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $photo = new InputFile((new StreamFactory())->createStream('test'), 'test.png');
        $entity = new MessageEntity('bold', 0, 5);
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendPhoto(
            12,
            $photo,
            'bcid1',
            99,
            'Caption',
            'parse',
            [$entity],
            true,
            false,
            true,
            false,
            'meid1',
            $replyParameters,
            $replyMarkup,
            true,
        );

        $this->assertSame(
            [
                'chat_id' => 12,
                'photo' => $photo,
                'business_connection_id' => 'bcid1',
                'message_thread_id' => 99,
                'caption' => 'Caption',
                'parse_mode' => 'parse',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => true,
                'has_spoiler' => false,
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
        $method = new SendPhoto(12, 'https://example.com/i.png');

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->send($method);

        $this->assertSame(7, $preparedResult->messageId);
    }
}
