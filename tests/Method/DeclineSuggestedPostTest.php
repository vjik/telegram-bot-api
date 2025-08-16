<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\DeclineSuggestedPost;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class DeclineSuggestedPostTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeclineSuggestedPost(1, 2);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('declineSuggestedPost', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'message_id' => 2,
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $method = new DeclineSuggestedPost(1, 2, 'Not suitable');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('declineSuggestedPost', $method->getApiMethod());
        assertSame(
            [
                'chat_id' => 1,
                'message_id' => 2,
                'comment' => 'Not suitable',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeclineSuggestedPost(1, 2);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}