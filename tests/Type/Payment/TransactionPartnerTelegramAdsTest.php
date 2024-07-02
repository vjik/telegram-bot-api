<?php

declare(strict_types=1);

namespace Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerTelegramAds;

final class TransactionPartnerTelegramAdsTest extends TestCase
{
    public function testBase(): void
    {
        $object = new TransactionPartnerTelegramAds();

        $this->assertSame('telegram_ads', $object->getType());
    }

    public function testFromTelegramResult(): void
    {
        $object = TransactionPartnerTelegramAds::fromTelegramResult([
            'type' => 'telegram_ads',
        ]);

        $this->assertSame('telegram_ads', $object->getType());
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Expected result as array. Got "string".');
        TransactionPartnerTelegramAds::fromTelegramResult('hello');
    }
}
