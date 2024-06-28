<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\Payment\RevenueWithdrawalStateSucceeded;

final class RevenueWithdrawalStateSucceededTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $object = new RevenueWithdrawalStateSucceeded(
            $date,
            'https://example.com/test',
        );

        $this->assertSame('succeeded', $object->getType());
        $this->assertSame($date, $object->date);
        $this->assertSame('https://example.com/test', $object->url);
    }

    public function testFromTelegramResult(): void
    {
        $date = new DateTimeImmutable();
        $object = RevenueWithdrawalStateSucceeded::fromTelegramResult([
            'type' => 'succeeded',
            'date' => $date->getTimestamp(),
            'url' => 'https://example.com/test',
        ]);

        $this->assertSame('succeeded', $object->getType());
        $this->assertSame($date->getTimestamp(), $object->date->getTimestamp());
        $this->assertSame('https://example.com/test', $object->url);
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Expected result as array. Got "string".');
        RevenueWithdrawalStateSucceeded::fromTelegramResult('hello');
    }
}
