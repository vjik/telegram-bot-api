<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultAudio;
use Vjik\TelegramBot\Api\Type\Inline\InputContactMessageContent;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\MessageEntity;

use function PHPUnit\Framework\assertSame;

final class InlineQueryResultAudioTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultAudio(
            'id1',
            'https://example.com/test.mp3',
            'The title',
        );

        assertSame('audio', $type->getType());
        assertSame(
            [
                'type' => 'audio',
                'id' => 'id1',
                'audio_url' => 'https://example.com/test.mp3',
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
        $type = new InlineQueryResultAudio(
            'id1',
            'https://example.com/test.mp3',
            'The title',
            'The caption',
            'HTML',
            [$entity],
            'The performer',
            15,
            $replyMarkup,
            $inputMessageContent,
        );

        assertSame('audio', $type->getType());
        assertSame(
            [
                'type' => 'audio',
                'id' => 'id1',
                'audio_url' => 'https://example.com/test.mp3',
                'title' => 'The title',
                'caption' => 'The caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'performer' => 'The performer',
                'audio_duration' => 15,
                'reply_markup' => $replyMarkup->toRequestArray(),
                'input_message_content' => $inputMessageContent->toRequestArray(),
            ],
            $type->toRequestArray(),
        );
    }
}
