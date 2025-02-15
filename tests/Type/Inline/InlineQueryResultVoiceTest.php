<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultVoice;
use Vjik\TelegramBot\Api\Type\Inline\InputContactMessageContent;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\MessageEntity;

use function PHPUnit\Framework\assertSame;

final class InlineQueryResultVoiceTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultVoice(
            'id1',
            'https://example.com/test.ogg',
            'The title',
        );

        assertSame('voice', $type->getType());
        assertSame(
            [
                'type' => 'voice',
                'id' => 'id1',
                'voice_url' => 'https://example.com/test.ogg',
                'title' => 'The title',
            ],
            $type->toRequestArray(),
        );
    }

    public function testFull(): void
    {
        $entity = new MessageEntity('bold', 0, 4);
        $inputMessageContent = new InputContactMessageContent('+79001234567', 'Sergei');
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $type = new InlineQueryResultVoice(
            'id1',
            'https://example.com/test.ogg',
            'The title',
            'The caption',
            'HTML',
            [$entity],
            15,
            $replyMarkup,
            $inputMessageContent,
        );

        assertSame('voice', $type->getType());
        assertSame(
            [
                'type' => 'voice',
                'id' => 'id1',
                'voice_url' => 'https://example.com/test.ogg',
                'title' => 'The title',
                'caption' => 'The caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'voice_duration' => 15,
                'reply_markup' => $replyMarkup->toRequestArray(),
                'input_message_content' => $inputMessageContent->toRequestArray(),
            ],
            $type->toRequestArray(),
        );
    }
}
