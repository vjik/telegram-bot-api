<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payments;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\Payments\RevenueWithdrawalStateFailed;

final class RevenueWithdrawalStateFailedTest extends TestCase
{
    public function testBase(): void
    {
        $object = new RevenueWithdrawalStateFailed();

        $this->assertSame('failed', $object->getType());
    }

    public function testFromTelegramResult(): void
    {
        $object = RevenueWithdrawalStateFailed::fromTelegramResult([
            'type' => 'failed',
        ]);

        $this->assertSame('failed', $object->getType());
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Expected result as array. Got "string".');
        RevenueWithdrawalStateFailed::fromTelegramResult('hello');
    }
}
