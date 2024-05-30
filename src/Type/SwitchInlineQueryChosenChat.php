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
        public ?string $query,
        public ?bool $allowUserChats,
        public ?bool $allowBotChats,
        public ?bool $allowGroupChats,
        public ?bool $allowChannelChats,
    ) {
    }

    public static function fromTelegramResult(mixed $result): self
    {
        ValueHelper::assertArrayResult($result);
        return new self(
            ValueHelper::getStringOrNull($result, 'query'),
            ValueHelper::getBooleanOrNull($result, 'allow_user_chats'),
            ValueHelper::getBooleanOrNull($result, 'allow_bot_chats'),
            ValueHelper::getBooleanOrNull($result, 'allow_group_chats'),
            ValueHelper::getBooleanOrNull($result, 'allow_channel_chats'),
        );
    }
}
