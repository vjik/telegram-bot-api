<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerFragment;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerOther;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerTelegramAds;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerUser;

final readonly class TransactionPartnerValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'fragment' => TransactionPartnerFragment::class,
            'telegram_ads' => TransactionPartnerTelegramAds::class,
            'user' => TransactionPartnerUser::class,
            'other' => TransactionPartnerOther::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown transaction partner type.';
    }
}
