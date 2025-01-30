<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#botcommandscopeallprivatechats
 *
 * @api
 */
final readonly class BotCommandScopeAllPrivateChats implements BotCommandScope
{
    public function getType(): string
    {
        return 'all_private_chats';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
        ];
    }
}
