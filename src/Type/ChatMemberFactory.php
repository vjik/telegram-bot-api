<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use Vjik\TelegramBot\Api\ParseResult\TelegramParseResultException;
use Vjik\TelegramBot\Api\ParseResult\ValueHelper;

final readonly class ChatMemberFactory
{
    public static function fromTelegramResult(mixed $result): ChatMember
    {
        ValueHelper::assertArrayResult($result);
        return match (ValueHelper::getString($result, 'status')) {
            'creator' => ChatMemberOwner::fromTelegramResult($result),
            'administrator' => ChatMemberAdministrator::fromTelegramResult($result),
            'member' => ChatMemberMember::fromTelegramResult($result),
            'restricted' => ChatMemberRestricted::fromTelegramResult($result),
            'left' => ChatMemberLeft::fromTelegramResult($result),
            'kicked' => ChatMemberBanned::fromTelegramResult($result),
            default => throw new TelegramParseResultException('Unknown chat member status.'),
        };
    }
}
