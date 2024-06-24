<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SendVideoNote;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

final class SendVideoNoteTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendVideoNote(12, 'https://example.com/wow.mp4');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('sendVideoNote', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 12,
                'video_note' => 'https://example.com/wow.mp4',
            ],
            $method->getData(),
        );
        $this->assertSame([], $method->getFiles());
    }

    public function testFull(): void
    {
        $video = new InputFile((new StreamFactory())->createStream('test'), 'test.mp4');
        $thumbnail = new InputFile((new StreamFactory())->createStream('test'), 'test.jpg');
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendVideoNote(
            12,
            $video,
            'bcid1',
            99,
            500,
            240,
            $thumbnail,
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
                'length' => 240,
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
                'video_note' => $video,
                'thumbnail' => $thumbnail,
            ],
            $method->getFiles(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendVideoNote(12, 'https://example.com/wow.mp4');

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
