<?php

declare(strict_types=1);

namespace Vjik\TelegramBot\Api\Type;

use DateTimeImmutable;

/**
 * @see https://core.telegram.org/bots/api#chatinvitelink
 */
final readonly class ChatInviteLink
{
    public function __construct(
        public string $inviteLlink,
        public User $creator,
        public bool $createsJoinRequest,
        public bool $isPrimary,
        public bool $isRevoked,
        public ?string $name,
        public ?DateTimeImmutable $expireDate,
        public ?int $memberLimit,
        public ?int $pendingJoinRequestCount,
    ) {
    }
}
