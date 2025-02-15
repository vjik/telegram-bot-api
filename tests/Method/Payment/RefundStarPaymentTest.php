<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Payment\RefundStarPayment;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class RefundStarPaymentTest extends TestCase
{
    public function testBase(): void
    {
        $method = new RefundStarPayment(1, 'test');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('refundStarPayment', $method->getApiMethod());
        assertSame(
            [
                'user_id' => 1,
                'telegram_payment_charge_id' => 'test',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new RefundStarPayment(1, 'test');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
