<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#botcommandscopechatmember
 */
final readonly class BotCommandScopeChatMember implements BotCommandScope
{
    public function __construct(
        public int|string $chatId,
        public int $userId,
    ) {}

    public function getType(): string
    {
        return 'chat_member';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
            'chat_id' => $this->chatId,
            'user_id' => $this->userId,
        ];
    }
}
