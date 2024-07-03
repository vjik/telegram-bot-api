<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#menubuttondefault
 */
final readonly class MenuButtonDefault implements MenuButton
{
    public function getType(): string
    {
        return 'default';
    }

    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        ValueHelper::assertArrayResult($result, $raw ?? $result);
        return new self();
    }

    public function toRequestArray(): array
    {
        return [
            'type' => $this->getType(),
        ];
    }
}
