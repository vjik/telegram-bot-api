<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\UpdatingMessage;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Constant\ParseMode;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\EditMessageText;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\LinkPreviewOptions;
use Vjik\TelegramBot\Api\Type\Message;
use Vjik\TelegramBot\Api\Type\MessageEntity;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class EditMessageTextTest extends TestCase
{
    public function testBase(): void
    {
        $method = new EditMessageText('test');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('editMessageText', $method->getApiMethod());
        assertSame(
            [
                'text' => 'test',
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $messageEntity = new MessageEntity('bold', 0, 4);
        $linkPreviewOptions = new LinkPreviewOptions(true);
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('hello')]]);
        $method = new EditMessageText(
            'test',
            'bcid1',
            23,
            34,
            'imid',
            ParseMode::HTML,
            [$messageEntity],
            $linkPreviewOptions,
            $replyMarkup,
        );

        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'chat_id' => 23,
                'message_id' => 34,
                'inline_message_id' => 'imid',
                'text' => 'test',
                'parse_mode' => 'HTML',
                'entities' => [$messageEntity->toRequestArray()],
                'link_preview_options' => $linkPreviewOptions->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditMessageText('test');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);
        assertTrue($preparedResult);

        $preparedResult = TestHelper::createSuccessStubApi([
            'message_id' => 7,
            'date' => 1620000000,
            'chat' => [
                'id' => 1,
                'type' => 'private',
            ],
        ])->call($method);
        assertInstanceOf(Message::class, $preparedResult);
        assertSame(7, $preparedResult->messageId);
    }
}
