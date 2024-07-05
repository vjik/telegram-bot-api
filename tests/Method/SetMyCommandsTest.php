<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\SetMyCommands;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\BotCommand;
use Vjik\TelegramBot\Api\Type\BotCommandScopeDefault;

final class SetMyCommandsTest extends TestCase
{
    public function testBase(): void
    {
        $botCommand = new BotCommand('test', 'Test description');
        $method = new SetMyCommands([$botCommand]);

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setMyCommands', $method->getApiMethod());
        $this->assertSame(
            [
                'commands' => [
                    $botCommand->toRequestArray(),
                ],
            ],
            $method->getData(),
        );
    }

    public function testFull(): void
    {
        $botCommand = new BotCommand('test', 'Test description');
        $scope = new BotCommandScopeDefault();
        $method = new SetMyCommands([$botCommand], $scope, 'ru');

        $this->assertSame(HttpMethod::POST, $method->getHttpMethod());
        $this->assertSame('setMyCommands', $method->getApiMethod());
        $this->assertSame(
            [
                'commands' => [
                    $botCommand->toRequestArray(),
                ],
                'scope' => $scope->toRequestArray(),
                'language_code' => 'ru',
            ],
            $method->getData(),
        );
    }

    public function testPrepareResult(): void
    {
        $method = new SetMyCommands([]);

        $preparedResult = TestHelper::createSuccessStubApi(true)->send($method);

        $this->assertTrue($preparedResult);
    }
}
