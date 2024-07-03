<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final class MenuButtonFactory
{
    public static function fromTelegramResult(mixed $result, mixed $raw = null): MenuButton
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return match (ValueHelper::getString($result, 'type', $raw)) {
            'commands' => MenuButtonCommands::fromTelegramResult($result, $raw),
            'web_app' => MenuButtonWebApp::fromTelegramResult($result, $raw),
            'default' => MenuButtonDefault::fromTelegramResult($result, $raw),
            default => throw new TelegramParseResultException('Unknown menu button type.', $raw),
        };
    }
}
