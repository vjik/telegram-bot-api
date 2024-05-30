<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

/**
 * @see https://core.telegram.org/bots/api#maybeinaccessiblemessage
 */
final readonly class MaybeInaccessibleMessageFactory
{
    public static function fromTelegramResult(mixed $result): Message|InaccessibleMessage
    {
        ValueHelper::assertArrayResult($result);
        $date = ValueHelper::getInteger($result, 'date');
        return $date === 0
            ? InaccessibleMessage::fromTelegramResult($result)
            : Message::fromTelegramResult($result);
    }
}
