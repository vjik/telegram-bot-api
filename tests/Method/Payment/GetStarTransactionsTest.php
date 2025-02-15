<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Payment;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Payment\GetStarTransactions;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;

final class GetStarTransactionsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetStarTransactions();

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getStarTransactions', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new GetStarTransactions(10, 100);

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getStarTransactions', $method->getApiMethod());
        assertSame([
            'offset' => 10,
            'limit' => 100,
        ], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetStarTransactions(99);

        $preparedResult = TestHelper::createSuccessStubApi([
            'transactions' => [],
        ])->call($method);

        assertSame([], $preparedResult->transactions);
    }
}
