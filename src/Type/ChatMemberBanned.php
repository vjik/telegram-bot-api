<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;
use Vjik\TelegramBot\Api\ParseResult\ValueProcessor\ChatMemberUntilDateValue;

/**
 * @see https://core.telegram.org/bots/api#chatmemberbanned
 *
 * @api
 */
final readonly class ChatMemberBanned implements ChatMember
{
    public function __construct(
        public User $user,
        #[ChatMemberUntilDateValue]
        public DateTimeImmutable|false $untilDate,
    ) {}

    public function getStatus(): string
    {
        return 'kicked';
    }

    public function getUser(): User
    {
        return $this->user;
    }
}
