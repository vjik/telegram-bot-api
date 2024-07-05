<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SendVoice;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

final class SendVoiceTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendVoice(12, 'https://example.com/audio.mp3');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('sendVoice', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 12,
                'voice' => 'https://example.com/audio.mp3',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $voice = new InputFile((new StreamFactory())->createStream('test'), 'test.mp3');
        $entity = new MessageEntity('bold', 0, 5);
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendVoice(
            12,
            $voice,
            'bcid1',
            99,
            'Caption',
            'HTML',
            [$entity],
            56,
            true,
            false,
            'meID',
            $replyParameters,
            $replyMarkup,
        );

        $this->assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'message_thread_id' => 99,
                'voice' => $voice,
                'caption' => 'Caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'duration' => 56,
                'disable_notification' => true,
                'protect_content' => false,
                'message_effect_id' => 'meID',
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendVoice(12, 'https://example.com/audio.mp3');

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
