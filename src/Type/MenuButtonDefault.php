<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#menubuttondefault
 */
final readonly class MenuButtonDefault implements MenuButton
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
