<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final readonly class ChatMemberFactory
{
    public static function fromTelegramResult(mixed $result, mixed $raw = null): ChatMember
    {
        $raw ??= $result;
        ValueHelper::assertArrayResult($result, $raw);
        return match (ValueHelper::getString($result, 'status', $raw)) {
            'creator' => ChatMemberOwner::fromTelegramResult($result, $raw),
            'administrator' => ChatMemberAdministrator::fromTelegramResult($result, $raw),
            'member' => ChatMemberMember::fromTelegramResult($result, $raw),
            'restricted' => ChatMemberRestricted::fromTelegramResult($result, $raw),
            'left' => ChatMemberLeft::fromTelegramResult($result, $raw),
            'kicked' => ChatMemberBanned::fromTelegramResult($result, $raw),
            default => throw new TelegramParseResultException('Unknown chat member status.', $raw),
        };
    }
}
