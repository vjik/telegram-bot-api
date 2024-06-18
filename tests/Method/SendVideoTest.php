<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SendVideo;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

final class SendVideoTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendVideo(12, 'https://example.com/wow.mp4');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('sendVideo', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 12,
                'video' => 'https://example.com/wow.mp4',
            ],
            $method->getData(),
        );
        $this->assertSame([], $method->getFiles());
    }

    public function testFull(): void
    {
        $video = new InputFile((new StreamFactory())->createStream('test'), 'test.mp4');
        $thumbnail = new InputFile((new StreamFactory())->createStream('test'), 'test.jpg');
        $entity = new MessageEntity('bold', 0, 5);
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendVideo(
            12,
            $video,
            'bcid1',
            99,
            500,
            300,
            200,
            $thumbnail,
            'Caption',
            'HTML',
            [$entity],
            false,
            true,
            false,
            false,
            true,
            'meID',
            $replyParameters,
            $replyMarkup,
        );

        $this->assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'message_thread_id' => 99,
                'duration' => 500,
                'width' => 300,
                'height' => 200,
                'caption' => 'Caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => false,
                'has_spoiler' => true,
                'supports_streaming' => false,
                'disable_notification' => false,
                'protect_content' => true,
                'message_effect_id' => 'meID',
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
        $this->assertSame(
            [
                'video' => $video,
                'thumbnail' => $thumbnail,
            ],
            $method->getFiles(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendVideo(12, 'https://example.com/wow.mp4');

        $preparedResult = $method->prepareResult([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ]);

        $this->assertSame(7, $preparedResult->messageId);
    }
}
