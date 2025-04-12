<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\Type\OwnedGift;
use Vjik\TelegramBot\Api\Type\OwnedGiftRegular;
use Vjik\TelegramBot\Api\Type\OwnedGiftUnique;

/**
 * @template-extends InterfaceValue<OwnedGift>
 */
final readonly class OwnedGiftValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'regular' => OwnedGiftRegular::class,
            'unique' => OwnedGiftUnique::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown owned gift type.';
    }
}
