<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Constant;

/**
 * @see https://core.telegram.org/bots/api#formatting-options
 * @see https://core.telegram.org/bots/api#messageentity
 */
final class MessageEntityType
{
    const MENTION = 'mention';
    const HASHTAG = 'hashtag';
    const CASHTAG = 'cashtag';
    const BOT_COMMAND = 'bot_command';
    const URL = 'url';
    const EMAIL = 'email';
    const PHONE_NUMBER = 'phone_number';
    const BOLD = 'bold';
    const ITALIC = 'italic';
    const UNDERLINE = 'underline';
    const STRIKETHROUGH = 'strikethrough';
    const SPOILER = 'spoiler';
    const BLOCKQUOTE = 'blockquote';
    const EXPANDABLE_BLOCKQUOTE = 'expandable_blockquote';
    const CODE = 'code';
    const PRE = 'pre';
    const TEXT_LINK = 'text_link';
    const TEXT_MENTION = 'text_mention';
    const CUSTOM_EMOJI = 'custom_emoji';
}
