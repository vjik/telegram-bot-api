<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\Update;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Method\Update\GetUpdates;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

final class GetUpdatesTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetUpdates();

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getUpdates', $method->getApiMethod());
        $this->assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $method = new GetUpdates(
            20,
            10,
            5000,
            ['u1', 'u2'],
        );

        $this->assertSame(
            [
                'offset' => 20,
                'limit' => 10,
                'timeout' => 5000,
                'allowed_updates' => ['u1', 'u2'],
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetUpdates();

        $preparedResult = TestHelper::createSuccessStubApi([
            ['update_id' => 1],
            ['update_id' => 2],
        ])->send($method);

        $this->assertCount(2, $preparedResult);
        $this->assertSame(1, $preparedResult[0]->updateId);
        $this->assertSame(2, $preparedResult[1]->updateId);
    }
}
