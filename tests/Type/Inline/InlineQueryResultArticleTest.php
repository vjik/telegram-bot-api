<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultArticle;
use Vjik\TelegramBot\Api\Type\Inline\InputContactMessageContent;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;

use function PHPUnit\Framework\assertSame;

final class InlineQueryResultArticleTest extends TestCase
{
    public function testBase(): void
    {
        $inputMessageContent = new InputContactMessageContent('+79001234567', 'Sergei');
        $type = new InlineQueryResultArticle(
            'id',
            'title',
            $inputMessageContent,
        );

        assertSame('article', $type->getType());
        assertSame(
            [
                'type' => 'article',
                'id' => 'id',
                'title' => 'title',
                'input_message_content' => $inputMessageContent->toRequestArray(),
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $inputMessageContent = new InputContactMessageContent('+79001234567', 'Sergei');
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $type = new InlineQueryResultArticle(
            'id',
            'title',
            $inputMessageContent,
            $replyMarkup,
            'https://example.com',
            'any desc',
            'https://example.com/thumb.png',
            100,
            200,
        );

        assertSame('article', $type->getType());
        assertSame(
            [
                'type' => 'article',
                'id' => 'id',
                'title' => 'title',
                'input_message_content' => $inputMessageContent->toRequestArray(),
                'reply_markup' => $replyMarkup->toRequestArray(),
                'url' => 'https://example.com',
                'description' => 'any desc',
                'thumbnail_url' => 'https://example.com/thumb.png',
                'thumbnail_width' => 100,
                'thumbnail_height' => 200,
            ],
            $type->toRequestArray(),
        );
    }
}
