<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultVenue;
use Vjik\TelegramBot\Api\Type\Inline\InputContactMessageContent;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;

final class InlineQueryResultVenueTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultVenue(
            'id1',
            59.9386292,
            30.3141308,
            'The title',
            'The address',
        );

        $this->assertSame('venue', $type->getType());
        $this->assertSame(
            [
                'type' => 'venue',
                'id' => 'id1',
                'latitude' => 59.9386292,
                'longitude' => 30.3141308,
                'title' => 'The title',
                'address' => 'The address',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $inputMessageContent = new InputContactMessageContent('+79001234567', 'Sergei');
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $type = new InlineQueryResultVenue(
            'id1',
            59.9386292,
            30.3141308,
            'The title',
            'The address',
            'The foursquare_id',
            'The foursquare_type',
            'The google_place_id',
            'The google_place_type',
            $replyMarkup,
            $inputMessageContent,
            'https://example.com/test.jpg',
            120,
            150,
        );

        $this->assertSame('venue', $type->getType());
        $this->assertSame(
            [
                'type' => 'venue',
                'id' => 'id1',
                'latitude' => 59.9386292,
                'longitude' => 30.3141308,
                'title' => 'The title',
                'address' => 'The address',
                'foursquare_id' => 'The foursquare_id',
                'foursquare_type' => 'The foursquare_type',
                'google_place_id' => 'The google_place_id',
                'google_place_type' => 'The google_place_type',
                'reply_markup' => $replyMarkup->toRequestArray(),
                'input_message_content' => $inputMessageContent->toRequestArray(),
                'thumbnail_url' => 'https://example.com/test.jpg',
                'thumbnail_width' => 120,
                'thumbnail_height' => 150,
            ],
            $type->toRequestArray(),
        );
    }
}
