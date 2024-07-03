<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final readonly class PaidMediaFactory
{
    public static function fromTelegramResult(mixed $result, mixed $raw = null): PaidMedia
    {
        ValueHelper::assertArrayResult($result, $raw);
        return match (ValueHelper::getString($result, 'type', $raw)) {
            'preview' => PaidMediaPreview::fromTelegramResult($result, $raw),
            'photo' => PaidMediaPhoto::fromTelegramResult($result, $raw),
            'video' => PaidMediaVideo::fromTelegramResult($result, $raw),
            default => throw new TelegramParseResultException('Unknown paid media type.', $raw),
        };
    }
}
