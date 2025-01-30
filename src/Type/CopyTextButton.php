<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#copytextbutton
 *
 * @api
 */
final readonly class CopyTextButton
{
    public function __construct(
        public string $text,
    ) {}

    public function toRequestArray(): array
    {
        return [
            'text' => $this->text,
        ];
    }
}
