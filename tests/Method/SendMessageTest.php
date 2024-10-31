<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SendMessage;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\LinkPreviewOptions;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

final class SendMessageTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendMessage(12, 'hello');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('sendMessage', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 12,
                'text' => 'hello',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 5);
        $linkPreviewOptions = new LinkPreviewOptions(true);
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendMessage(
            12,
            'hello',
            'bcid1',
            99,
            'parse',
            [$entity],
            $linkPreviewOptions,
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
                'text' => 'hello',
                'parse_mode' => 'parse',
                'entities' => [$entity->toRequestArray()],
                'link_preview_options' => $linkPreviewOptions->toRequestArray(),
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
        $method = new SendMessage(12, 'hello');

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
