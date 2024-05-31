<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;
use Vjik\TelegramBot\Api\Type\Game\CallbackGame;

/**
 * @see https://core.telegram.org/bots/api#inlinekeyboardbutton
 */
final readonly class InlineKeyboardButton
{
    public function __construct(
        public string $text,
        public ?string $url = null,
        public ?string $callbackData = null,
        public ?WebAppInfo $webApp = null,
        public ?LoginUrl $loginUrl = null,
        public ?string $switchInlineQuery = null,
        public ?string $switchInlineQueryCurrentChat = null,
        public ?SwitchInlineQueryChosenChat $switchInlineQueryChosenChat = null,
        public ?CallbackGame $callbackGame = null,
        public ?bool $pay = null,
    ) {
    }

    public function toRequestArray(): array
    {
        return array_filter([
            'text' => $this->text,
            'url' => $this->url,
            'callback_data' => $this->callbackData,
            'web_app' => $this->webApp?->toRequestArray(),
            'login_url' => $this->loginUrl?->toRequestArray(),
            'switch_inline_query' => $this->switchInlineQuery,
            'switch_inline_query_current_chat' => $this->switchInlineQueryCurrentChat,
            'switch_inline_query_chosen_chat' => $this->switchInlineQueryChosenChat?->toRequestArray(),
            'callback_game' => $this->callbackGame?->toRequestArray(),
            'pay' => $this->pay,
        ]);
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getString($result, 'text'),
            ValueHelper::getStringOrNull($result, 'url'),
            ValueHelper::getStringOrNull($result, 'callback_data'),
            array_key_exists('web_app', $result)
                ? WebAppInfo::fromTelegramResult($result['web_app'])
                : null,
            array_key_exists('login_url', $result)
                ? LoginUrl::fromTelegramResult($result['login_url'])
                : null,
            ValueHelper::getStringOrNull($result, 'switch_inline_query'),
            ValueHelper::getStringOrNull($result, 'switch_inline_query_current_chat'),
            array_key_exists('switch_inline_query_chosen_chat', $result)
                ? SwitchInlineQueryChosenChat::fromTelegramResult($result['switch_inline_query_chosen_chat'])
                : null,
            array_key_exists('callback_game', $result)
                ? CallbackGame::fromTelegramResult($result['callback_game'])
                : null,
            ValueHelper::getBooleanOrNull($result, 'pay'),
        );
    }
}
