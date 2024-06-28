<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\Payment\RevenueWithdrawalStatePending;

final class RevenueWithdrawalStatePendingTest extends TestCase
{
    public function testBase(): void
    {
        $object = new RevenueWithdrawalStatePending();

        $this->assertSame('pending', $object->getType());
    }

    public function testFromTelegramResult(): void
    {
        $object = RevenueWithdrawalStatePending::fromTelegramResult([
            'type' => 'pending',
        ]);

        $this->assertSame('pending', $object->getType());
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Expected result as array. Got "string".');
        RevenueWithdrawalStatePending::fromTelegramResult('hello');
    }
}
