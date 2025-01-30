<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#botcommandscopedefault
 *
 * @api
 */
final readonly class BotCommandScopeDefault implements BotCommandScope
{
    public function getType(): string
    {
        return 'default';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
        ];
    }
}
