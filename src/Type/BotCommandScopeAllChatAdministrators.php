<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#botcommandscopeallchatadministrators
 *
 * @api
 */
final readonly class BotCommandScopeAllChatAdministrators implements BotCommandScope
{
    public function getType(): string
    {
        return 'all_chat_administrators';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
        ];
    }
}
