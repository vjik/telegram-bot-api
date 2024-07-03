<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final class ChatBoostSourceFactory
{
    public static function fromTelegramResult(mixed $result, mixed $raw = null): ChatBoostSource
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return match (ValueHelper::getString($result, 'source', $raw)) {
            'premium' => ChatBoostSourcePremium::fromTelegramResult($result, $raw),
            'gift_code' => ChatBoostSourceGiftCode::fromTelegramResult($result, $raw),
            'giveaway' => ChatBoostSourceGiveaway::fromTelegramResult($result, $raw),
            default => throw new TelegramParseResultException('Unknown chat boost source.', $raw),
        };
    }
}
