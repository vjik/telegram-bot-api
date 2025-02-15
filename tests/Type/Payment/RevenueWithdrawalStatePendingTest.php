<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Payment\RevenueWithdrawalStatePending;

use function PHPUnit\Framework\assertSame;

final class RevenueWithdrawalStatePendingTest extends TestCase
{
    public function testBase(): void
    {
        $object = new RevenueWithdrawalStatePending();

        assertSame('pending', $object->getType());
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create([
            'type' => 'pending',
        ], null, RevenueWithdrawalStatePending::class);

        assertSame('pending', $object->getType());
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $objectFactory->create('hello', null, RevenueWithdrawalStatePending::class);
    }
}
