<?php

declare(strict_types=1);

namespace Method\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Payment\EditUserStarSubscription;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class EditUserStarSubscriptionTest extends TestCase
{
    public function testBase(): void
    {
        $method = new EditUserStarSubscription(1, 'tpcid2', false);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('editUserStarSubscription', $method->getApiMethod());
        $this->assertSame(
            [
                'user_id' => 1,
                'telegram_payment_charge_id' => 'tpcid2',
                'is_canceled' => false,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new EditUserStarSubscription(1, 'tpcid2', false);

        $preparedResult = TestHelper::createSuccessStubApi(true)->send($method);

        $this->assertTrue($preparedResult);
    }
}
