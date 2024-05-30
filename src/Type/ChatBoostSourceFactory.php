<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final class ChatBoostSourceFactory
{
    public static function fromTelegramResult(mixed $result): ChatBoostSource
    {
        ValueHelper::assertArrayResult($result);
        return match (ValueHelper::getString($result, 'source')) {
            'premium' => ChatBoostSourcePremium::fromTelegramResult($result),
            'gift_code' => ChatBoostSourceGiftCode::fromTelegramResult($result),
            'giveaway' => ChatBoostSourceGiveaway::fromTelegramResult($result),
            default => throw new TelegramParseResultException('Unknown chat boost source.'),
        };
    }
}
