<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultLocation;
use Vjik\TelegramBot\Api\Type\Inline\InputContactMessageContent;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;

final class InlineQueryResultLocationTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultLocation(
            'id1',
            59.9386292,
            30.3141308,
            'The title',
        );

        $this->assertSame('location', $type->getType());
        $this->assertSame(
            [
                'type' => 'location',
                'id' => 'id1',
                'latitude' => 59.9386292,
                'longitude' => 30.3141308,
                'title' => 'The title',
            ],
            $type->toRequestArray()
        );
    }

    public function testFull(): void
    {
        $inputMessageContent = new InputContactMessageContent('+79001234567', 'Sergei');
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $type = new InlineQueryResultLocation(
            'id1',
            59.9386292,
            30.3141308,
            'The title',
            15.23,
            100,
            200,
            104,
            $replyMarkup,
            $inputMessageContent,
            'https://example.com/test.jpg',
            532,
            234,
        );

        $this->assertSame('location', $type->getType());
        $this->assertSame(
            [
                'type' => 'location',
                'id' => 'id1',
                'latitude' => 59.9386292,
                'longitude' => 30.3141308,
                'title' => 'The title',
                'horizontal_accuracy' => 15.23,
                'live_period' => 100,
                'heading' => 200,
                'proximity_alert_radius' => 104,
                'reply_markup' => $replyMarkup->toRequestArray(),
                'input_message_content' => $inputMessageContent->toRequestArray(),
                'thumbnail_url' => 'https://example.com/test.jpg',
                'thumbnail_width' => 532,
                'thumbnail_height' => 234,
            ],
            $type->toRequestArray()
        );
    }
}
