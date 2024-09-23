<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\ParseResult\ValueProcessor;

use Vjik\TelegramBot\Api\Type\ChatMember;
use Vjik\TelegramBot\Api\Type\ChatMemberAdministrator;
use Vjik\TelegramBot\Api\Type\ChatMemberBanned;
use Vjik\TelegramBot\Api\Type\ChatMemberLeft;
use Vjik\TelegramBot\Api\Type\ChatMemberMember;
use Vjik\TelegramBot\Api\Type\ChatMemberOwner;
use Vjik\TelegramBot\Api\Type\ChatMemberRestricted;

/**
 * @template-extends InterfaceValue<ChatMember>
 */
final readonly class ChatMemberValue extends InterfaceValue
{
    public function getTypeKey(): string
    {
        return 'status';
    }

    public function getClassMap(): array
    {
        return [
            'creator' => ChatMemberOwner::class,
            'administrator' => ChatMemberAdministrator::class,
            'member' => ChatMemberMember::class,
            'restricted' => ChatMemberRestricted::class,
            'left' => ChatMemberLeft::class,
            'kicked' => ChatMemberBanned::class,
        ];
    }

    public function getUnknownTypeMessage(): string
    {
        return 'Unknown chat member status.';
    }
}
