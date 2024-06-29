<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultCachedAudio;
use Vjik\TelegramBot\Api\Type\Inline\InputContactMessageContent;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\MessageEntity;

final class InlineQueryResultCachedAudioTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultCachedAudio(
            'id1',
            'audio_id1',
        );

        $this->assertSame('audio', $type->getType());
        $this->assertSame(
            [
                'type' => 'audio',
                'id' => 'id1',
                'audio_file_id' => 'audio_id1',
            ],
            $type->toRequestArray()
        );
    }

    public function testFull():void
    {
        $entity = new MessageEntity('bold', 0, 4);
        $inputMessageContent = new InputContactMessageContent('+79001234567', 'Sergei');
        $replyMarkup = new InlineKeyboardMarkup([[new InlineKeyboardButton('test')]]);
        $type = new InlineQueryResultCachedAudio(
            'id1',
            'audio_id1',
            'The caption',
            'HTML',
            [$entity],
            $replyMarkup,
            $inputMessageContent,
        );

        $this->assertSame('audio', $type->getType());
        $this->assertSame(
            [
                'type' => 'audio',
                'id' => 'id1',
                'audio_file_id' => 'audio_id1',
                'caption' => 'The caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'reply_markup' => $replyMarkup->toRequestArray(),
                'input_message_content' => $inputMessageContent->toRequestArray(),
            ],
            $type->toRequestArray()
        );
    }
}
