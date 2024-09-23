<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\Type\ChatBoostSource;
use Vjik\TelegramBot\Api\Type\ChatBoostSourceGiftCode;
use Vjik\TelegramBot\Api\Type\ChatBoostSourceGiveaway;
use Vjik\TelegramBot\Api\Type\ChatBoostSourcePremium;

/**
 * @template-extends InterfaceValue<ChatBoostSource>
 */
final readonly class ChatBoostSourceValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'source';
    }

    public function getClassMap(): array
    {
        return [
            'premium' => ChatBoostSourcePremium::class,
            'gift_code' => ChatBoostSourceGiftCode::class,
            'giveaway' => ChatBoostSourceGiveaway::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown chat boost source.';
    }
}
