<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#menubuttoncommands
 */
final readonly class MenuButtonCommands implements MenuButton
{
    public function getType(): string
    {
        return 'commands';
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
        ];
    }
}
