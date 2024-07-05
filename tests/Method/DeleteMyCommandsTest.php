<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\DeleteMyCommands;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\BotCommandScopeDefault;

final class DeleteMyCommandsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new DeleteMyCommands();

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('deleteMyCommands', $method->getApiMethod());
        $this->assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $scope = new BotCommandScopeDefault();
        $method = new DeleteMyCommands($scope, 'ru');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('deleteMyCommands', $method->getApiMethod());
        $this->assertSame(
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

        $preparedResult = TestHelper::createSuccessStubApi(true)->send($method);

        $this->assertTrue($preparedResult);
    }
}
