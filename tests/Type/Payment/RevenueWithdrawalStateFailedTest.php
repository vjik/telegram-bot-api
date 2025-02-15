<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Payment\RevenueWithdrawalStateFailed;

use function PHPUnit\Framework\assertSame;

final class RevenueWithdrawalStateFailedTest extends TestCase
{
    public function testBase(): void
    {
        $object = new RevenueWithdrawalStateFailed();

        assertSame('failed', $object->getType());
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create([
            'type' => 'failed',
        ], null, RevenueWithdrawalStateFailed::class);

        assertSame('failed', $object->getType());
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $objectFactory->create('hello', null, RevenueWithdrawalStateFailed::class);
    }
}
