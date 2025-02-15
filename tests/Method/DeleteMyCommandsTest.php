<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\DeleteMyCommands;
use Vjik\TelegramBot\Api\Transport\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\BotCommandScopeDefault;

use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

final class DeleteMyCommandsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteMyCommands();

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteMyCommands', $method->getApiMethod());
        assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $scope = new BotCommandScopeDefault();
        $method = new DeleteMyCommands($scope, 'ru');

        assertSame(HttpMethod::POST, $method->getHttpMethod());
        assertSame('deleteMyCommands', $method->getApiMethod());
        assertSame(
            [
                'scope' => $scope->toRequestArray(),
                'language_code' => 'ru',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new DeleteMyCommands();

        $preparedResult = TestHelper::createSuccessStubApi(true)->call($method);

        assertTrue($preparedResult);
    }
}
