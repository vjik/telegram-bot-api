<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final class MenuButtonFactory
{
    public static function fromTelegramResult(mixed $result): MenuButton
    {
        ValueHelper::assertArrayResult($result);
        return match (ValueHelper::getString($result, 'type')) {
            'commands' => MenuButtonCommands::fromTelegramResult($result),
            'web_app' => MenuButtonWebApp::fromTelegramResult($result),
            'default' => MenuButtonDefault::fromTelegramResult($result),
            default => throw new TelegramParseResultException('Unknown menu button type.'),
        };
    }
}
