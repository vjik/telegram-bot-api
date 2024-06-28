<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\Type\Payment\StarTransaction;
use Vjik\TelegramBot\Api\Type\Payment\StarTransactions;

final class StarTransactionsTest extends TestCase
{
    public function testBase(): void
    {
        $transaction = new StarTransaction('id1', 2, new DateTimeImmutable());
        $object = new StarTransactions([$transaction]);

        $this->assertSame([$transaction], $object->transactions);
    }

    public function testFromTelegramResult(): void
    {
        $object = StarTransactions::fromTelegramResult([
            'transactions' => [
                [
                    'id' => 'id1',
                    'amount' => 2,
                    'date' => 123456789,
                ],
            ],
        ]);

        $this->assertCount(1, $object->transactions);
        $this->assertSame('id1', $object->transactions[0]->id);
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Expected result as array. Got "string".');
        StarTransactions::fromTelegramResult('hello');
    }
}
