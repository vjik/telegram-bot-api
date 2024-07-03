<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final class ReactionTypeFactory
{
    public static function fromTelegramResult(mixed $result, mixed $raw = null): ReactionType
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return match (ValueHelper::getString($result, 'type', $raw)) {
            'emoji' => ReactionTypeEmoji::fromTelegramResult($result, $raw),
            'custom_emoji' => ReactionTypeCustomEmoji::fromTelegramResult($result, $raw),
            default => throw new TelegramParseResultException('Unknown reaction type.', $raw),
        };
    }
}
