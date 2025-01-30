<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#chatjoinrequest
 *
 * @api
 */
final readonly class ChatJoinRequest
{
    public function __construct(
        public Chat $chat,
        public User $from,
        public int $userChatId,
        public DateTimeImmutable $date,
        public ?string $bio = null,
        public ?ChatInviteLink $inviteLink = null,
    ) {}
}
