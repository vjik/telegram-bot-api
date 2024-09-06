<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SendPaidMedia;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\InputPaidMediaPhoto;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

final class SendPaidMediaTest extends TestCase
{
    public function testBase(): void
    {
        $inputMedia = new InputPaidMediaPhoto('https://example.com/face.png');
        $method = new SendPaidMedia(12, 25, [$inputMedia]);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('sendPaidMedia', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 12,
                'star_count' => 25,
                'media' => [$inputMedia->toRequestArray()],
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $file = new InputFile((new StreamFactory())->createStream());
        $inputMedia = new InputPaidMediaPhoto($file);
        $entity = new MessageEntity('bold', 0, 4);
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendPaidMedia(
            12,
            25,
            [$inputMedia],
            'The caption',
            'HTML',
            [$entity],
            true,
            false,
            true,
            $replyParameters,
            $replyMarkup,
            'bcid1',
            'test-payload',
        );

        $this->assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'star_count' => 25,
                'media' => [
                    [
                        'type' => 'photo',
                        'media' => 'attach://file0',
                    ],
                ],
                'payload' => 'test-payload',
                'caption' => 'The caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => true,
                'disable_notification' => false,
                'protect_content' => true,
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
                'file0' => $file,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendPaidMedia(12, 25, []);

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
