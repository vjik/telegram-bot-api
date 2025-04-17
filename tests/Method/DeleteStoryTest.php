<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\DeleteStory;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class DeleteStoryTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteStory('bcid1', 123);

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteStory', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'bcid1',
                'story_id' => 123,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteStory('business_connection_id', 123);

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
