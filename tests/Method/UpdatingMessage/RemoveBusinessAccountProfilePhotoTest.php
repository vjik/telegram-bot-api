<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method\UpdatingMessage;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\UpdatingMessage\RemoveBusinessAccountProfilePhoto;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Transport\HttpMethod;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class RemoveBusinessAccountProfilePhotoTest extends TestCase
{
    public function testBase(): void
    {
        $method = new RemoveBusinessAccountProfilePhoto('connection123');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('removeBusinessAccountProfilePhoto', $method->getApiMethod());
        assertSame(
            [
                'business_connection_id' => 'connection123',
            ],
            $method->getData()
        );
    }

    public function testFull(): void
    {
        $method = new RemoveBusinessAccountProfilePhoto('connection123', true);

        assertSame(
            [
                'business_connection_id' => 'connection123',
                'is_public' => true,
            ],
            $method->getData()
        );
    }

    public function testPrepareResult(): void
    {
        $method = new RemoveBusinessAccountProfilePhoto('connection1');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
