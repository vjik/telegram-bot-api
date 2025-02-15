<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Payment\RevenueWithdrawalStateFailed;
use Vjik\TelegramBot\Api\Type\Payment\TransactionPartnerFragment;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertNull;
use function PHPUnit\Framework\assertSame;

final class TransactionPartnerFragmentTest extends TestCase
{
    public function testBase(): void
    {
        $object = new TransactionPartnerFragment();

        assertSame('fragment', $object->getType());
        assertNull($object->withdrawalState);
    }

    public function testFull(): void
    {
        $withdrawalState = new RevenueWithdrawalStateFailed();
        $object = new TransactionPartnerFragment($withdrawalState);

        assertSame('fragment', $object->getType());
        assertSame($withdrawalState, $object->withdrawalState);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create([
            'type' => 'fragment',
            'withdrawal_state' => [
                'type' => 'failed',
            ],
        ], null, TransactionPartnerFragment::class);

        assertSame('fragment', $object->getType());
        assertInstanceOf(RevenueWithdrawalStateFailed::class, $object->withdrawalState);
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $objectFactory->create('hello', null, TransactionPartnerFragment::class);
    }
}
