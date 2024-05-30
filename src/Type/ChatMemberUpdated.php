<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#chatmemberupdated
 */
final readonly class ChatMemberUpdated
{
    public function __construct(
        public Chat $chat,
        public User $from,
        public DateTimeImmutable $date,
        public ChatMember $oldChatMember,
        public ChatMember $newChatMember,
        public ?ChatInviteLink $inviteLink,
        public ?bool $viaJoinRequest,
        public ?bool $viaChatFolderInviteLink,
    ) {
    }
}
