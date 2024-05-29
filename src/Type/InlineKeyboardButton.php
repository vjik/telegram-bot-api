<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\Type\Game\CallbackGame;

/**
 * @see https://core.telegram.org/bots/api#inlinekeyboardbutton
 */
final readonly class InlineKeyboardButton
{
    public function __construct(
        public string $text,
        public ?string $url,
        public ?string $callbackData,
        public ?WebAppInfo $webApp,
        public ?LoginUrl $loginUrl,
        public ?string $switchInlineQuery,
        public ?string $switchInlineQueryCurrentChat,
        public ?SwitchInlineQueryChosenChat $switchInlineQueryChosenChat,
        public ?CallbackGame $callbackGame,
        public ?bool $pay,
    ) {
    }
}
