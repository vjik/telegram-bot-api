<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Payments;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\Payments\GetStarTransactions;
use Vjik\TelegramBot\Api\Request\HttpMethod;

final class GetStarTransactionsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetStarTransactions();

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getStarTransactions', $method->getApiMethod());
        $this->assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new GetStarTransactions(10, 100);

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getStarTransactions', $method->getApiMethod());
        $this->assertSame([
            'offset' => 10,
            'limit' => 100,
        ], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetStarTransactions(99);

        $preparedResult = $method->prepareResult([
            'transactions' => [],
        ]);

        $this->assertSame([], $preparedResult->transactions);
    }
}
