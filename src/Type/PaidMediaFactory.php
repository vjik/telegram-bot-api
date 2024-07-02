<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final readonly class PaidMediaFactory
{
    public static function fromTelegramResult(mixed $result): PaidMedia
    {
        ValueHelper::assertArrayResult($result);
        return match (ValueHelper::getString($result, 'type')) {
            'preview' => PaidMediaPreview::fromTelegramResult($result),
            'photo' => PaidMediaPhoto::fromTelegramResult($result),
            'video' => PaidMediaVideo::fromTelegramResult($result),
            default => throw new TelegramParseResultException('Unknown paid media type.'),
        };
    }
}
