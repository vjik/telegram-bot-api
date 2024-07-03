<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#maybeinaccessiblemessage
 */
final readonly class MaybeInaccessibleMessageFactory
{
    public static function fromTelegramResult(mixed $result, mixed $raw = null): Message|InaccessibleMessage
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        $date = ValueHelper::getInteger($result, 'date', $raw);
        return $date === 0
            ? InaccessibleMessage::fromTelegramResult($result, $raw)
            : Message::fromTelegramResult($result, $raw);
    }
}
