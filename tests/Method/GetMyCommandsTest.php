<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Method;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Method\GetMyCommands;
use Vjik\TelegramBot\Api\Request\HttpMethod;
use Vjik\TelegramBot\Api\Tests\Support\TestHelper;
use Vjik\TelegramBot\Api\Type\BotCommand;
use Vjik\TelegramBot\Api\Type\BotCommandScopeDefault;

final class GetMyCommandsTest extends TestCase
{
    public function testBase(): void
    {
        $method = new GetMyCommands();

        $this->assertSame(HttpMethod::GET, $method->getHttpMethod());
        $this->assertSame('getMyCommands', $method->getApiMethod());
        $this->assertSame([], $method->getData());
    }

    public function testFull(): void
    {
        $scope = new BotCommandScopeDefault();
        $method = new GetMyCommands($scope, 'ru');

        $this->assertSame(
            [
                'scope' => $scope->toRequestArray(),
                'language_code' => 'ru',
            ],
            $method->getData()
        );
    }

    public function testPrepareResult(): void
    {
        $method = new GetMyCommands();

        $preparedResult = TestHelper::createSuccessStubApi([
            [
                'command' => 'start',
                'description' => 'Start command',
            ]
        ])->send($method);

        $this->assertCount(1, $preparedResult);
        $this->assertInstanceOf(BotCommand::class, $preparedResult[0]);
        $this->assertSame('start', $preparedResult[0]->command);
    }
}
