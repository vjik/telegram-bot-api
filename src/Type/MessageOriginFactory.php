<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final class MessageOriginFactory
{
    public static function fromTelegramResult(mixed $result, mixed $raw = null): MessageOrigin
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return match (ValueHelper::getString($result, 'type', $raw)) {
            'user' => MessageOriginUser::fromTelegramResult($result, $raw),
            'hidden_user' => MessageOriginHiddenUser::fromTelegramResult($result, $raw),
            'chat' => MessageOriginChat::fromTelegramResult($result, $raw),
            'channel' => MessageOriginChannel::fromTelegramResult($result, $raw),
            default => throw new TelegramParseResultException('Unknown message origin type.', $raw),
        };
    }
}
