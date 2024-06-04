<?php

declare(strict_types=1);

namespace Type\Payments;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Payments\OrderInfo;
use Vjik\TelegramBot\Api\Type\Payments\SuccessfulPayment;

final class SuccessfulPaymentTest extends TestCase
{
    public function testSuccessfulPayment(): void
    {
        $successfulPayment = new SuccessfulPayment(
            'RUB',
            200,
            'pl12',
            'tpc_id',
            'ppc_id',
        );

        $this->assertSame('RUB', $successfulPayment->currency);
        $this->assertSame(200, $successfulPayment->totalAmount);
        $this->assertSame('pl12', $successfulPayment->invoicePayload);
        $this->assertSame('tpc_id', $successfulPayment->telegramPaymentChargeId);
        $this->assertSame('ppc_id', $successfulPayment->providerPaymentChargeId);
        $this->assertNull($successfulPayment->shippingOptionId);
        $this->assertNull($successfulPayment->orderInfo);
    }

    public function testFromTelegramResult(): void
    {
        $successfulPayment = SuccessfulPayment::fromTelegramResult([
            'currency' => 'RUB',
            'total_amount' => 900,
            'invoice_payload' => 'pl12',
            'telegram_payment_charge_id' => 'tpcId',
            'provider_payment_charge_id' => 'ppcId',
            'shipping_option_id' => 'soId',
            'order_info' => [
                'name' => 'OrderName',
            ],
        ]);

        $this->assertSame('RUB', $successfulPayment->currency);
        $this->assertSame(900, $successfulPayment->totalAmount);
        $this->assertSame('pl12', $successfulPayment->invoicePayload);
        $this->assertSame('tpcId', $successfulPayment->telegramPaymentChargeId);
        $this->assertSame('ppcId', $successfulPayment->providerPaymentChargeId);
        $this->assertSame('soId', $successfulPayment->shippingOptionId);

        $this->assertInstanceOf(OrderInfo::class, $successfulPayment->orderInfo);
        $this->assertSame('OrderName', $successfulPayment->orderInfo->name);
    }
}
