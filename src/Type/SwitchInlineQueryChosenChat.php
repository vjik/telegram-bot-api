<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#switchinlinequerychosenchat
 */
final readonly class SwitchInlineQueryChosenChat
{
    public function __construct(
        public ?string $query = null,
        public ?bool $allowUserChats = null,
        public ?bool $allowBotChats = null,
        public ?bool $allowGroupChats = null,
        public ?bool $allowChannelChats = null,
    ) {
    }

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'query' => $this->query,
                'allow_user_chats' => $this->allowUserChats,
                'allow_bot_chats' => $this->allowBotChats,
                'allow_group_chats' => $this->allowGroupChats,
                'allow_channel_chats' => $this->allowChannelChats,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return new self(
            ValueHelper::getStringOrNull($result, 'query', $raw),
            ValueHelper::getBooleanOrNull($result, 'allow_user_chats', $raw),
            ValueHelper::getBooleanOrNull($result, 'allow_bot_chats', $raw),
            ValueHelper::getBooleanOrNull($result, 'allow_group_chats', $raw),
            ValueHelper::getBooleanOrNull($result, 'allow_channel_chats', $raw),
        );
    }
}
