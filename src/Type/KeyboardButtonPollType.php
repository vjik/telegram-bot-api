<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#keyboardbuttonpolltype
 */
final readonly class KeyboardButtonPollType
{
    public function __construct(
        public ?string $type = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'type' => $this->type,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
