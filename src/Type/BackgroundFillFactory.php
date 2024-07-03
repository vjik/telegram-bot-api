<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final readonly class BackgroundFillFactory
{
    public static function fromTelegramResult(mixed $result, mixed $raw = null): BackgroundFill
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return match (ValueHelper::getString($result, 'type', $raw)) {
            'solid' => BackgroundFillSolid::fromTelegramResult($result, $raw),
            'gradient' => BackgroundFillGradient::fromTelegramResult($result, $raw),
            'freeform_gradient' => BackgroundFillFreeformGradient::fromTelegramResult($result, $raw),
            default => throw new TelegramParseResultException('Unknown background fill type.', $raw),
        };
    }
}
