<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BotCommandScopeDefault;

final class BotCommandScopeDefaultTest extends TestCase
{
    public function testBase(): void
    {
        $scope = new BotCommandScopeDefault();

        $this->assertSame('default', $scope->getType());

        $this->assertSame(
            [
                'type' => 'default',
            ],
            $scope->toRequestArray(),
        );
    }
}
