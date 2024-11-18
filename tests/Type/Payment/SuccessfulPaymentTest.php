<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Payment\OrderInfo;
use Vjik\TelegramBot\Api\Type\Payment\SuccessfulPayment;

final class SuccessfulPaymentTest extends TestCase
{
    public function testSuccessfulPayment(): void
    {
        $type = new SuccessfulPayment(
            'RUB',
            200,
            'pl12',
            'tpc_id',
            'ppc_id',
        );

        $this->assertSame('RUB', $type->currency);
        $this->assertSame(200, $type->totalAmount);
        $this->assertSame('pl12', $type->invoicePayload);
        $this->assertSame('tpc_id', $type->telegramPaymentChargeId);
        $this->assertSame('ppc_id', $type->providerPaymentChargeId);
        $this->assertNull($type->shippingOptionId);
        $this->assertNull($type->orderInfo);
        $this->assertNull($type->subscriptionExpirationDate);
        $this->assertNull($type->isRecurring);
        $this->assertNull($type->isFirstRecurring);
    }

    public function testFromTelegramResult(): void
    {
        $type = (new ObjectFactory())->create([
            'currency' => 'RUB',
            'total_amount' => 900,
            'invoice_payload' => 'pl12',
            'subscription_expiration_date' => 1731915609,
            'is_recurring' => true,
            'is_first_recurring' => true,
            'telegram_payment_charge_id' => 'tpcId',
            'provider_payment_charge_id' => 'ppcId',
            'shipping_option_id' => 'soId',
            'order_info' => [
                'name' => 'OrderName',
            ],
        ], null, SuccessfulPayment::class);

        $this->assertSame('RUB', $type->currency);
        $this->assertSame(900, $type->totalAmount);
        $this->assertSame('pl12', $type->invoicePayload);
        $this->assertSame('tpcId', $type->telegramPaymentChargeId);
        $this->assertSame('ppcId', $type->providerPaymentChargeId);
        $this->assertSame('soId', $type->shippingOptionId);

        $this->assertInstanceOf(OrderInfo::class, $type->orderInfo);
        $this->assertSame('OrderName', $type->orderInfo->name);

        $this->assertSame(1731915609, $type->subscriptionExpirationDate?->getTimestamp());
        $this->assertTrue($type->isRecurring);
        $this->assertTrue($type->isFirstRecurring);
    }
}
