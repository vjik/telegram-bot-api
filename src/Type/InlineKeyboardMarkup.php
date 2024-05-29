<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * https://core.telegram.org/bots/api#inlinekeyboardmarkup
 */
final readonly class InlineKeyboardMarkup
{
    /**
     * @param array[] $inlineKeyboard
     * @psalm-param list<list<InlineKeyboardButton>> $inlineKeyboard
     */
    public function __construct(
        public array $inlineKeyboard,
    ) {
    }
}
