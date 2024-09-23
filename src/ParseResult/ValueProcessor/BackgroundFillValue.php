<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\Type\BackgroundFill;
use Vjik\TelegramBot\Api\Type\BackgroundFillFreeformGradient;
use Vjik\TelegramBot\Api\Type\BackgroundFillGradient;
use Vjik\TelegramBot\Api\Type\BackgroundFillSolid;

/**
 * @template-extends InterfaceValue<BackgroundFill>
 */
final readonly class BackgroundFillValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'solid' => BackgroundFillSolid::class,
            'gradient' => BackgroundFillGradient::class,
            'freeform_gradient' => BackgroundFillFreeformGradient::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown background fill type.';
    }
}
