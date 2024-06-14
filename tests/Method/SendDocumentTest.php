<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use HttpSoft\Message\StreamFactory;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SendDocument;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Type\ForceReply;
use Vjik\TelegramBot\Api\Type\InputFile;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

final class SendDocumentTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SendDocument(12, 'https://example.com/file.doc');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('sendDocument', $method->getApiMethod());
        $this->assertSame(
            [
                'chat_id' => 12,
                'document' => 'https://example.com/file.doc',
            ],
            $method->getData(),
        );
        $this->assertSame([], $method->getFiles());
    }

    public function testFull(): void
    {
        $document = new InputFile((new StreamFactory())->createStream('test'), 'test.doc');
        $thumbnail = new InputFile((new StreamFactory())->createStream('test'), 'test.jpg');
        $entity = new MessageEntity('bold', 0, 5);
        $replyParameters = new ReplyParameters(23);
        $replyMarkup = new ForceReply();
        $method = new SendDocument(
            12,
            $document,
            'bcid1',
            99,
            $thumbnail,
            'Caption',
            'HTML',
            [$entity],
            false,
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
                'caption' => 'Caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'disable_content_type_detection' => false,
                'disable_notification' => true,
                'protect_content' => false,
                'message_effect_id' => 'meID',
                'reply_parameters' => $replyParameters->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
        $this->assertSame(
            [
                'document' => $document,
                'thumbnail' => $thumbnail,
            ],
            $method->getFiles(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SendDocument(12, 'https://example.com/file.doc');

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
