<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final class ReactionTypeFactory
{
    public static function fromTelegramResult(mixed $result): ReactionType
    {
        ValueHelper::assertArrayResult($result);
        return match (ValueHelper::getString($result, 'type')) {
            'emoji' => ReactionTypeEmoji::fromTelegramResult($result),
            'custom_emoji' => ReactionTypeCustomEmoji::fromTelegramResult($result),
            default => throw new TelegramParseResultException('Unknown reaction type.'),
        };
    }
}
