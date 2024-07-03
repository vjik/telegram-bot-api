<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#giveawaycreated
 */
final readonly class GiveawayCreated
{
    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        return new self();
    }
}
