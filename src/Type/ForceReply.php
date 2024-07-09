<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#forcereply
 */
final readonly class ForceReply
{
    public function __construct(
        public ?string $inputFieldPlaceholder = null,
        public ?bool $selective = null,
    ) {}

    public function toRequestArray(): array
    {
        return array_filter(
            [
                'force_reply' => true,
                'input_field_placeholder' => $this->inputFieldPlaceholder,
                'selective' => $this->selective,
            ],
            static fn(mixed $value): bool => $value !== null,
        );
    }
}
