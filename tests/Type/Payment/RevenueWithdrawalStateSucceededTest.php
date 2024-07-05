<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
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
        $object = (new ObjectFactory())->create([
            'type' => 'succeeded',
            'date' => $date->getTimestamp(),
            'url' => 'https://example.com/test',
        ], null, RevenueWithdrawalStateSucceeded::class);

        $this->assertSame('succeeded', $object->getType());
        $this->assertSame($date->getTimestamp(), $object->date->getTimestamp());
        $this->assertSame('https://example.com/test', $object->url);
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $objectFactory->create('hello', null, RevenueWithdrawalStateSucceeded::class);
    }
}
