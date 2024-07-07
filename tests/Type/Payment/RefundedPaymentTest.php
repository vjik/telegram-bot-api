<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Payment\RefundedPayment;

final class RefundedPaymentTest extends TestCase
{
    public function testBase(): void
    {
        $type = new RefundedPayment('XTR', 12, 'ip', 'tpid');

        $this->assertSame('XTR', $type->currency);
        $this->assertSame(12, $type->totalAmount);
        $this->assertSame('ip', $type->invoicePayload);
        $this->assertSame('tpid', $type->telegramPaymentChargeId);
        $this->assertNull($type->providerPaymentChargeId);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create(
            [
                'currency' => 'XTR',
                'total_amount' => 12,
                'invoice_payload' => 'ip',
                'telegram_payment_charge_id' => 'tpid',
                'provider_payment_charge_id' => 'ppcid',
            ],
            null,
            RefundedPayment::class,
        );

        $this->assertSame('XTR', $type->currency);
        $this->assertSame(12, $type->totalAmount);
        $this->assertSame('ip', $type->invoicePayload);
        $this->assertSame('tpid', $type->telegramPaymentChargeId);
        $this->assertSame('ppcid', $type->providerPaymentChargeId);
    }
}
