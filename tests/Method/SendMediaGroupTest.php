<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SendMediaGroup;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\InputMediaPhoto;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

final class SendMediaGroupTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputMediaPhoto('https://example.com/face.png');
        $method = new SendMediaGroup(12, [$inputMedia]);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('sendMediaGroup', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 12,
                'media' => [$inputMedia->toRequestArray()],
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $file = new InputFile((new StreamFactory())->createStream());
        $inputMedia = new InputMediaPhoto($file);
        $replyParameters = new ReplyParameters(23);
        $method = new SendMediaGroup(
            12,
            [$inputMedia],
            'bcid',
            99,
            true,
            false,
            'id1',
            $replyParameters,
        );

        $this->assertSame(
            [
                'business_connection_id' => 'bcid',
                'chat_id' => 12,
                'message_thread_id' => 99,
                'media' => [
                    [
                        'type' => 'photo',
                        'media' => 'attach://file0',
                    ],
                ],
                'disable_notification' => true,
                'protect_content' => false,
                'message_effect_id' => 'id1',
                'reply_parameters' => $replyParameters->toRequestArray(),
                'file0' => $file,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendMediaGroup(12, []);

        $result = TestHelper::createSuccessStubApi([
            [
                'message_id' => 7,
                'date' => 1620000000,
                'chat' => [
                    'id' => 1,
                    'type' => 'private',
                ],
            ],
        ])->send($method);

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertInstanceOf(Message::class, $result[0]);
        $this->assertSame(7, $result[0]->messageId);
    }
}
