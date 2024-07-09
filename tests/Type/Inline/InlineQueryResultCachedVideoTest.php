<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Inline;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Inline\InlineQueryResultCachedVideo;
use Vjik\TelegramBot\Api\Type\Inline\InputContactMessageContent;
use Vjik\TelegramBot\Api\Type\InlineKeyboardButton;
use Vjik\TelegramBot\Api\Type\InlineKeyboardMarkup;
use Vjik\TelegramBot\Api\Type\MessageEntity;

final class InlineQueryResultCachedVideoTest extends TestCase
{
    public function testBase(): void
    {
        $type = new InlineQueryResultCachedVideo(
            'id1',
            'video_id1',
            'The title',
        );

        $this->assertSame('video', $type->getType());
        $this->assertSame(
            [
                'type' => 'video',
                'id' => 'id1',
                'video_file_id' => 'video_id1',
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
        $type = new InlineQueryResultCachedVideo(
            'id1',
            'video_id1',
            'The title',
            'The description',
            'The caption',
            'HTML',
            [$entity],
            true,
            $replyMarkup,
            $inputMessageContent,
        );

        $this->assertSame('video', $type->getType());
        $this->assertSame(
            [
                'type' => 'video',
                'id' => 'id1',
                'video_file_id' => 'video_id1',
                'title' => 'The title',
                'description' => 'The description',
                'caption' => 'The caption',
                'parse_mode' => 'HTML',
                'caption_entities' => [$entity->toRequestArray()],
                'show_caption_above_media' => true,
                'reply_markup' => $replyMarkup->toRequestArray(),
                'input_message_content' => $inputMessageContent->toRequestArray(),
            ],
            $type->toRequestArray(),
        );
    }
}
