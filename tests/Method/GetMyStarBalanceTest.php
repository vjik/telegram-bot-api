<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetMyStarBalance;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Transport\HttpMethod;

use Vjik\TelegramBot\Api\Type\StarAmount;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;

final class GetMyStarBalanceTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetMyStarBalance();

        assertSame(HttpMethod::GET, $method->getHttpMethod());
        assertSame('getMyStarBalance', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testPrepareResult(): void
    {
        $method = new GetMyStarBalance();

        $result = TestHelper::createSuccessStubApi([
            'amount' => 9,
        ])->call($method);

        assertInstanceOf(StarAmount::class, $result);
        assertSame(9, $result->amount);
    }
}
