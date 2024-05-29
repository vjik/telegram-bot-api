<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

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
}
