<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\TransferBusinessAccountStars;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Transport\HttpMethod;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class TransferBusinessAccountStarsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new TransferBusinessAccountStars('connection1', 100);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('transferBusinessAccountStars', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'connection1',
                'star_count' => 100,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new TransferBusinessAccountStars('connection1', 100);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
