<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payments;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\Payments\StarTransaction;
use Vjik\TelegramBot\Api\Type\Payments\TransactionPartnerOther;

final class StarTransactionTest extends TestCase
{
    public function testBase(): void
    {
        $date = new DateTimeImmutable();
        $object = new StarTransaction('id1', 2, $date);

        $this->assertSame('id1', $object->id);
        $this->assertSame(2, $object->amount);
        $this->assertSame($date, $object->date);
        $this->assertNull($object->source);
        $this->assertNull($object->receiver);
    }

    public function testFull(): void
    {
        $date = new DateTimeImmutable();
        $partner1 = new TransactionPartnerOther();
        $partner2 = new TransactionPartnerOther();
        $object = new StarTransaction(
            'id1',
            2,
            $date,
            $partner1,
            $partner2,
        );

        $this->assertSame('id1', $object->id);
        $this->assertSame(2, $object->amount);
        $this->assertSame($date, $object->date);
        $this->assertSame($partner1, $object->source);
        $this->assertSame($partner2, $object->receiver);
    }

    public function testFromTelegramResult(): void
    {
        $object = StarTransaction::fromTelegramResult([
            'id' => 'id1',
            'amount' => 2,
            'date' => 123456789,
            'source' => [
                'type' => 'other',
            ],
            'receiver' => [
                'type' => 'other',
            ],
        ]);

        $this->assertSame('id1', $object->id);
        $this->assertSame(2, $object->amount);
        $this->assertEquals(new DateTimeImmutable('@123456789'), $object->date);
        $this->assertInstanceOf(TransactionPartnerOther::class, $object->source);
        $this->assertInstanceOf(TransactionPartnerOther::class, $object->receiver);
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Expected result as array. Got "string".');
        StarTransaction::fromTelegramResult('hello');
    }
}
