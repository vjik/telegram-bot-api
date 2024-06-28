<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\Payment\OrderInfo;
use Vjik\TelegramBot\Api\Type\Payment\PreCheckoutQuery;
use Vjik\TelegramBot\Api\Type\User;

final class PreCheckoutQueryTest extends TestCase
{
    public function testPreCheckoutQuery(): void
    {
        $user = new User(1, false, 'Vjik');
        $preCheckoutQuery = new PreCheckoutQuery(
            'id',
            $user,
            'RUB',
            123,
            'pl23'
        );

        $this->assertSame('id', $preCheckoutQuery->id);
        $this->assertSame($user, $preCheckoutQuery->from);
        $this->assertSame('RUB', $preCheckoutQuery->currency);
        $this->assertSame(123, $preCheckoutQuery->totalAmount);
        $this->assertSame('pl23', $preCheckoutQuery->invoicePayload);
        $this->assertNull($preCheckoutQuery->shippingOptionId);
        $this->assertNull($preCheckoutQuery->orderInfo);
    }

    public function testFromTelegramResult(): void
    {
        $preCheckoutQuery = PreCheckoutQuery::fromTelegramResult([
            'id' => 'id',
            'from' => [
                'id' => 1,
                'is_bot' => false,
                'first_name' => 'Vjik',
            ],
            'currency' => 'RUB',
            'total_amount' => 123,
            'invoice_payload' => 'pl23',
            'shipping_option_id' => 'o12',
            'order_info' => [
                'name' => 'OrderName',
            ],
        ]);

        $this->assertSame('id', $preCheckoutQuery->id);

        $this->assertInstanceOf(User::class, $preCheckoutQuery->from);
        $this->assertSame(1, $preCheckoutQuery->from->id);

        $this->assertSame('RUB', $preCheckoutQuery->currency);
        $this->assertSame(123, $preCheckoutQuery->totalAmount);
        $this->assertSame('pl23', $preCheckoutQuery->invoicePayload);
        $this->assertSame('o12', $preCheckoutQuery->shippingOptionId);

        $this->assertInstanceOf(OrderInfo::class, $preCheckoutQuery->orderInfo);
        $this->assertSame('OrderName', $preCheckoutQuery->orderInfo->name);
    }
}
