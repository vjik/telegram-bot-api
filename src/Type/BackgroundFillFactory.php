<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final readonly class BackgroundFillFactory
{
    public static function fromTelegramResult(mixed $result): BackgroundFill
    {
        ValueHelper::assertArrayResult($result);
        return match (ValueHelper::getString($result, 'type')) {
            'solid' => BackgroundFillSolid::fromTelegramResult($result),
            'gradient' => BackgroundFillGradient::fromTelegramResult($result),
            'freeform_gradient' => BackgroundFillFreeformGradient::fromTelegramResult($result),
            default => throw new TelegramParseResultException('Unknown background fill type.'),
        };
    }
}
