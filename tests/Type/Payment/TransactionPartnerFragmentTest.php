<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\Payment\RevenueWithdrawalStateFailed;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerFragment;

final class TransactionPartnerFragmentTest extends TestCase
{
    public function testBase(): void
    {
        $object = new TransactionPartnerFragment();

        $this->assertSame('fragment', $object->getType());
        $this->assertNull($object->withdrawalState);
    }

    public function testFull(): void
    {
        $withdrawalState = new RevenueWithdrawalStateFailed();
        $object = new TransactionPartnerFragment($withdrawalState);

        $this->assertSame('fragment', $object->getType());
        $this->assertSame($withdrawalState, $object->withdrawalState);
    }

    public function testFromTelegramResult(): void
    {
        $object = TransactionPartnerFragment::fromTelegramResult([
            'type' => 'fragment',
            'withdrawal_state' => [
                'type' => 'failed',
            ],
        ]);

        $this->assertSame('fragment', $object->getType());
        $this->assertInstanceOf(RevenueWithdrawalStateFailed::class, $object->withdrawalState);
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Expected result as array. Got "string".');
        TransactionPartnerFragment::fromTelegramResult('hello');
    }
}
