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
        return array_filter(
            [
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
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getString($result, 'text', $raw),
            ValueHelper::getStringOrNull($result, 'url', $raw),
            ValueHelper::getStringOrNull($result, 'callback_data', $raw),
            array_key_exists('web_app', $result)
                ? WebAppInfo::fromTelegramResult($result['web_app'], $raw)
                : null,
            array_key_exists('login_url', $result)
                ? LoginUrl::fromTelegramResult($result['login_url'], $raw)
                : null,
            ValueHelper::getStringOrNull($result, 'switch_inline_query', $raw),
            ValueHelper::getStringOrNull($result, 'switch_inline_query_current_chat', $raw),
            array_key_exists('switch_inline_query_chosen_chat', $result)
                ? SwitchInlineQueryChosenChat::fromTelegramResult($result['switch_inline_query_chosen_chat'], $raw)
                : null,
            array_key_exists('callback_game', $result)
                ? CallbackGame::fromTelegramResult($result['callback_game'], $raw)
                : null,
            ValueHelper::getBooleanOrNull($result, 'pay', $raw),
        );
    }
}
