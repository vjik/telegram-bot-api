<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final class MessageOriginFactory
{
    public static function fromTelegramResult(mixed $result): MessageOrigin
    {
        ValueHelper::assertArrayResult($result);
        return match (ValueHelper::getString($result, 'type')) {
            'user' => MessageOriginUser::fromTelegramResult($result),
            'hidden_user' => MessageOriginHiddenUser::fromTelegramResult($result),
            'chat' => MessageOriginChat::fromTelegramResult($result),
            'channel' => MessageOriginChannel::fromTelegramResult($result),
            default => throw new TelegramParseResultException('Unknown message origin type.'),
        };
    }
}
