<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Tests\Type;

use PHPUnit\Framework\TestCase;
use Vjik\TelegramBot\Api\Type\BotCommandScopeDefault;

use function PHPUnit\Framework\assertSame;

final class BotCommandScopeDefaultTest extends TestCase
{
    public function testBase(): void
    {
        $scope = new BotCommandScopeDefault();

        assertSame('default', $scope->getType());

        assertSame(
            [
                'type' => 'default',
            ],
            $scope->toRequestArray(),
        );
    }
}
