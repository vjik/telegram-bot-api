<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#botcommandscopechat
 */
final readonly class BotCommandScopeChat implements BotCommandScope
{
    public function __construct(
        public int|string $chatId,
    ) {}

    public function getType(): string
    {
        return 'chat';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'chat_id' => $this->chatId,
        ];
    }
}
