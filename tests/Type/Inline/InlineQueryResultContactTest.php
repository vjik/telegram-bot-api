<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultContact;
use Vjik\TelegramBot\Api\Type\Inline\InputContactMessageContent;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;

final class InlineQueryResultContactTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultContact(
            'id1',
            '+79001234567',
            'Sergei',
        );

        $this->assertSame('contact', $type->getType());
        $this->assertSame(
            [
                'type' => 'contact',
                'id' => 'id1',
                'phone_number' => '+79001234567',
                'first_name' => 'Sergei',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $inputMessageContent = new InputContactMessageContent('+79001234567', 'Sergei');
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $type = new InlineQueryResultContact(
            'id1',
            '+79001234567',
            'Sergei',
            'Predvoditelev',
            'myvcard',
            $replyMarkup,
            $inputMessageContent,
            'https://example.com/test.jpg',
            120,
            200,
        );

        $this->assertSame('contact', $type->getType());
        $this->assertSame(
            [
                'type' => 'contact',
                'id' => 'id1',
                'phone_number' => '+79001234567',
                'first_name' => 'Sergei',
                'last_name' => 'Predvoditelev',
                'vcard' => 'myvcard',
                'reply_markup' => $replyMarkup->toRequestArray(),
                'input_message_content' => $inputMessageContent->toRequestArray(),
                'thumbnail_url' => 'https://example.com/test.jpg',
                'thumbnail_width' => 120,
                'thumbnail_height' => 200,
            ],
            $type->toRequestArray(),
        );
    }
}
