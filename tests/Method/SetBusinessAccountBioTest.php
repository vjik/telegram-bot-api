<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetBusinessAccountBio;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\TrueValue;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Transport\HttpMethod;

use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class SetBusinessAccountBioTest extends TestCase
{
    public function testBase(): void
    {
        $method = new SetBusinessAccountBio('connection1');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('setBusinessAccountBio', $method->getApiMethod());
        assertSame(['business_connection_id' => 'connection1'], $method->getData());
        assertInstanceOf(TrueValue::class, $method->getResultType());
    }

    public function testFull(): void
    {
        $method = new SetBusinessAccountBio('connection1', 'Короткое описание аккаунта');

        assertSame(
            [
                'business_connection_id' => 'connection1',
                'bio' => 'Короткое описание аккаунта',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetBusinessAccountBio('connection1');

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
