<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\CopyMessage;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

final class CopyMessageTest extends TestCase
{
    public function testBase(): void
    {
        $method = new CopyMessage(1, 2, 3);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('copyMessage', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 1,
                'from_chat_id' => 2,
                'message_id' => 3,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $messageEntity = new MessageEntity('bold', 0, 4);
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new CopyMessage(
            1,
            2,
            3,
            4,
            'test',
            'MarkdownV2',
            [$messageEntity],
            true,
            false,
            true,
            $replyParameters,
            $replyMarkup,
            true,
            17,
        );

        $this->assertSame(
            [
                'chat_id' => 1,
                'message_thread_id' => 4,
                'from_chat_id' => 2,
                'message_id' => 3,
                'video_start_timestamp' => 17,
                'caption' => 'test',
                'parse_mode' => 'MarkdownV2',
                'caption_entities' => [$messageEntity->toRequestArray()],
                'show_caption_above_media' => true,
                'disable_notification' => false,
                'protect_content' => true,
                'allow_paid_broadcast' => true,
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new CopyMessage(1, 2, 3);

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
        ])->call($method);

        $this->assertSame(7, $preparedResult->messageId);
    }
}
