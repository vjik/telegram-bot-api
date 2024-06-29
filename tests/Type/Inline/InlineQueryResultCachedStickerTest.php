<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultCachedSticker;
use Vjik\TelegramBot\Api\Type\Inline\InputContactMessageContent;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;

final class InlineQueryResultCachedStickerTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultCachedSticker(
            'id1',
            'sticker_id1',
        );

        $this->assertSame('sticker', $type->getType());
        $this->assertSame(
            [
                'type' => 'sticker',
                'id' => 'id1',
                'sticker_file_id' => 'sticker_id1',
            ],
            $type->toRequestArray()
        );
    }

    public function testFull(): void
    {
        $inputMessageContent = new InputContactMessageContent('+79001234567', 'Sergei');
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $type = new InlineQueryResultCachedSticker(
            'id1',
            'sticker_id1',
            $replyMarkup,
            $inputMessageContent,
        );

        $this->assertSame('sticker', $type->getType());
        $this->assertSame(
            [
                'type' => 'sticker',
                'id' => 'id1',
                'sticker_file_id' => 'sticker_id1',
                'reply_markup' => $replyMarkup->toRequestArray(),
                'input_message_content' => $inputMessageContent->toRequestArray(),
            ],
            $type->toRequestArray()
        );
    }
}
