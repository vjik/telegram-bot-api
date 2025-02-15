<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetMyDefaultAdministratorRights;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\ChatAdministratorRights;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetMyDefaultAdministratorRightsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetMyDefaultAdministratorRights();

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setMyDefaultAdministratorRights', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $rights = new ChatAdministratorRights(true, false, true, true, true, true, true, true, true, true, true);
        $method = new SetMyDefaultAdministratorRights($rights, false);

        assertSame(
            [
                'rights' => $rights->toRequestArray(),
                'for_channels' => false,
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetMyDefaultAdministratorRights();

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
