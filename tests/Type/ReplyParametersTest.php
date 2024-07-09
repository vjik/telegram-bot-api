<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\MessageEntity;
use Vjik\TelegramBot\Api\Type\ReplyParameters;

final class ReplyParametersTest extends TestCase
{
    public function testBase(): void
    {
        $replyParameters = new ReplyParameters(99);

        $this->assertSame(99, $replyParameters->messageId);
        $this->assertNull($replyParameters->chatId);
        $this->assertNull($replyParameters->allowSendingWithoutReply);
        $this->assertNull($replyParameters->quote);
        $this->assertNull($replyParameters->quoteParseMode);
        $this->assertNull($replyParameters->quoteEntities);
        $this->assertNull($replyParameters->quotePosition);

        $this->assertSame(
            [
                'message_id' => 99,
            ],
            $replyParameters->toRequestArray(),
        );
    }

    public function testFilled(): void
    {
        $quoteEntity = new MessageEntity('bold', 0, 4);
        $replyParameters = new ReplyParameters(
            99,
            102,
            true,
            'text',
            'best',
            [$quoteEntity],
            23,
        );

        $this->assertSame(99, $replyParameters->messageId);
        $this->assertSame(102, $replyParameters->chatId);
        $this->assertTrue($replyParameters->allowSendingWithoutReply);
        $this->assertSame('text', $replyParameters->quote);
        $this->assertSame('best', $replyParameters->quoteParseMode);
        $this->assertSame([$quoteEntity], $replyParameters->quoteEntities);
        $this->assertSame(23, $replyParameters->quotePosition);

        $this->assertSame(
            [
                'message_id' => 99,
                'chat_id' => 102,
                'allow_sending_without_reply' => true,
                'quote' => 'text',
                'quote_parse_mode' => 'best',
                'quote_entities' => [$quoteEntity->toRequestArray()],
                'quote_position' => 23,
            ],
            $replyParameters->toRequestArray(),
        );
    }
}
