<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\Type\Payment\TransactionPartner;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerAffiliateProgram;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerChat;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerFragment;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerOther;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerTelegramAds;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerTelegramApi;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerUser;

/**
 * @template-extends InterfaceValue<TransactionPartner>
 */
final readonly class TransactionPartnerValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'type';
    }

    public function getClassMap(): array
    {
        return [
            'affiliate_program' => TransactionPartnerAffiliateProgram::class,
            'fragment' => TransactionPartnerFragment::class,
            'telegram_ads' => TransactionPartnerTelegramAds::class,
            'telegram_api' => TransactionPartnerTelegramApi::class,
            'user' => TransactionPartnerUser::class,
            'chat' => TransactionPartnerChat::class,
            'other' => TransactionPartnerOther::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown transaction partner type.';
    }
}
