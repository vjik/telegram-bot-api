<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type\Payment;

use DateTimeImmutable;
use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ObjectFactory;
use Vjik\TelegramBot\Api\Type\Payment\StarTransaction;
use Vjik\TelegramBot\Api\Type\Payment\StarTransactions;

use function PHPUnit\Framework\assertCount;
use function PHPUnit\Framework\assertSame;

final class StarTransactionsTest extends TestCase
{
    public function testBase(): void
    {
        $transaction = new StarTransaction('id1', 2, new DateTimeImmutable());
        $object = new StarTransactions([$transaction]);

        assertSame([$transaction], $object->transactions);
    }

    public function testFromTelegramResult(): void
    {
        $object = (new ObjectFactory())->create([
            'transactions' => [
                [
                    'id' => 'id1',
                    'amount' => 2,
                    'date' => 123456789,
                ],
            ],
        ], null, StarTransactions::class);

        assertCount(1, $object->transactions);
        assertSame('id1', $object->transactions[0]->id);
    }

    public function testFromTelegramResultWithInvalidResult(): void
    {
        $objectFactory = new ObjectFactory();

        $this->expectException(TelegramParseResultException::class);
        $this->expectExceptionMessage('Invalid type of value. Expected type is "array", but got "string".');
        $objectFactory->create('hello', null, StarTransactions::class);
    }
}
