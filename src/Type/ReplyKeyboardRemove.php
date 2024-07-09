<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#replykeyboardremove
 */
final readonly class ReplyKeyboardRemove
{
    public function __construct(
        public ?bool $selective = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'remove_keyboard' => true,
                'selective' => $this->selective,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
