<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SendAnimation;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

final class SendAnimationTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendAnimation(12, 'https://example.com/anime.gif');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('sendAnimation', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 12,
                'animation' => 'https://example.com/anime.gif',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $animation = new InputFile((new StreamFactory())->createStream('test'), 'test.gif');
        $thumbnail = new InputFile((new StreamFactory())->createStream('test'), 'test.jpg');
        $entity = new MessageEntity('bold', 0, 5);
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendAnimation(
            12,
            $animation,
            'bcid1',
            99,
            100,
            240,
            320,
            $thumbnail,
            'Caption',
            'HTML',
            [$entity],
            true,
            false,
            false,
            true,
            'meID',
            $replyParameters,
            $replyMarkup,
            true,
        );

        $this->assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 12,
                'message_thread_id' => 99,
                'animation' => $animation,
                'duration' => 100,
                'width' => 240,
                'height' => 320,
                'thumbnail' => $thumbnail,
                'caption' => 'Caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => true,
                'has_spoiler' => false,
                'disable_notification' => false,
                'protect_content' => true,
                'allow_paid_broadcast' => true,
                'message_effect_id' => 'meID',
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendAnimation(12, 'https://example.com/anime.gif');

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
