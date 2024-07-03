<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

/**
 * @see https://core.telegram.org/bots/api#videochatstarted
 */
final readonly class VideoChatStarted
{
    public static function fromTelegramResult(mixed $result, mixed $raw = null): self
    {
        return new self();
    }
}
