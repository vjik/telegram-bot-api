<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\UpdatingMessage;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\EditMessageReplyMarkup;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\Message;

final class EditMessageReplyMarkupTest extends TestCase
{
    public function testBase(): void
    {
        $method = new EditMessageReplyMarkup();

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('editMessageReplyMarkup', $method->getApiMethod());
        $this->assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('hello')]]);
        $method = new EditMessageReplyMarkup(
            'bcid1',
            23,
            34,
            'imid',
            $replyMarkup,
        );

        $this->assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 23,
                'message_id' => 34,
                'inline_message_id' => 'imid',
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditMessageReplyMarkup();

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);
        $this->assertTrue($preparedResult);

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->call($method);
        $this->assertInstanceOf(Message::class, $preparedResult);
        $this->assertSame(7, $preparedResult->messageId);
    }
}
